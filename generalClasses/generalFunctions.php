<?php

class GeneralFunction {

	function endsWith($input, $wanted) {

		return substr($input, -strlen($wanted))===$wanted;
		
	}

}