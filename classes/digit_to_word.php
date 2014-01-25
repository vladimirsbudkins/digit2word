<?php
	/*
		для лубой конверации нам понадобится: 
			массив со:
				словестным обозначением чисел;
				сообщение об ошибке;
				дефис, соединение и разделитель.
			функция проверки:
				проверяет число в соответствии с правилом/ми.
			функция конвертации:
				конвертирует число, если прошло проверку, 
				иначе возвращает ошибку.
	*/
	abstract class digit_to_word
	{
		public $dictionary = array();
	    abstract public function check_data($digit);
	    abstract public function convert($digit);
	}

	
?>