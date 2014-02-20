<?php
namespace Development;

class Electronics
{
    public function __construct()
    {

    }

	/**
	 * @return Electronics
	 */
	public static function getInstance()
	{
		return new Electronics();
	}

	public function setLights( $lights )
	{
	}

	public function accelerate()
	{
	}
}