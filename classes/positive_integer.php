<?php
	/*
		возвращает целое положительное чило, не больше PHP_INT_MAX
		(так и не разобрался как у себя поставить PHP_INT_SIZE 
		больше 4 бит, возможно у Вас больше тогда должно до 10^15 выводить)
	*/	
	class positive_integer extends digit_to_word
	{
		public $dictionary = array();
		//при инитиализации класса заполняем в массив из ini файла
		public function __construct()
		{
			$this->dictionary = parse_ini_file("config/en.ini");
		}
		//проверяем на: 
		//число, положительное, целочисленное и входит ли в PHP_INT_MAX
	    public function check_data($digit) 
	    {
			if(is_numeric($digit) && $digit > 0 && (int)$digit == $digit && (int)$digit < 0 + PHP_INT_MAX)
				return true;
			else
				return false;
	    }
	    //конвертация. если прошли проверку, то преобразуем, 
	    //иначе сообщение об ошибке 
	    public function convert($digit) {
	    	if($this->check_data($digit) == true)
	    	{
				switch ($digit) 
				{	//если число меньше 21 просто выводим из массива 
					case $digit < 21:
						$string = $this->dictionary[$digit];
						break;
					case $digit < 100:
						//получаем десятки
			            $tens = ((int) ($digit / 10)) * 10;
			            //получаем единицы
			            $units  = $digit % 10;
			            //если нет едениц выводим из массива
			            $string = $this->dictionary[$tens];
			            //если есть то 'клеим' десятки с еденицами раделяя дефисом
			            if ($units)
			                $string .= $this->dictionary['hyphen'] . $this->dictionary[$units];
			            break;
					case $digit < 1000:
						//получаем сотни
			            $hundreds  = $digit / 100;
			            //получаем остаток
			            $remainder = $digit % 100;
			            //если нет остатка выводим из массива
			            $string = $this->dictionary[$hundreds] . ' ' . $this->dictionary[100];
			            //если есть, то прогоняем остаток еще раз через функцию
			            // разделяем 'соединителем' и 'клеим' ответ
			            if ($remainder) 
			            	$string .= $this->dictionary['conjunction'] . $this->convert($remainder);
			            break;
			        default:
			        	//тут 'танцы с бубном' были! 
			        	//можно было бы конечно и препода по матеме потрепать, но но гугл выручил :)
						$baseUnit = pow(1000, floor(log($digit, 1000)));
						$numBaseUnits = (int) ($digit / $baseUnit);
						//получаем остаток
						$remainder = $digit % $baseUnit;
						//если нет остатка, то собираем строку
						$string = $this->convert($numBaseUnits) . ' ' . $this->dictionary[$baseUnit];
						//если есть и < 100, то 'соеденитель' иначе 'разделитель'
						//и опять магическое склеивание строк 
						if($remainder)
						{
							$string .= $remainder < 100 ? $this->dictionary['conjunction'] : $this->dictionary['separator'];
							$string .= $this->convert($remainder);
						}
						break;
				}
				//возвращаем результат
				return $string;
	    	}
	    	else
	    		return $this->dictionary['error'];
	    }
	}
?>