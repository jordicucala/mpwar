<?php

namespace Development;

class UserTest extends \PHPUnit_Framework_TestCase{





    public function testvalidateDataUser(){

        $service_provider = new ServiceProvider();
        $service_provider->setService('Development\UserModel');
        $newUser = new \Development\User($service_provider);
        $newUser2 = new \Development\User($service_provider);
        $newUser3 = new \Development\User($service_provider);

        $userdata = array(
            "email" => "jordicucala@hotmail.com",
            "password" => "pass"
        );

        try {
            $newUser->newUser($userdata);
        }
        catch(\InvalidArgumentException $e){
            $errors = $newUser->getErrors();
            $this->assertEquals($errors[0], 'User name is required.');
        }


        $userdata = array(
            "password" => "pass"
        );

        try {
            $newUser2->newUser($userdata);
        }
        catch(\InvalidArgumentException $e){
            $errors = $newUser2->getErrors();
            $this->assertEquals($errors[0], 'User name is required.');
            $this->assertEquals($errors[1], 'Email is required.');
        }


        $userdata = array(
            "passwordbad" => "pass"
        );

        try {
            $newUser3->newUser($userdata);
        }
        catch(\InvalidArgumentException $e){
            $errors = $newUser3->getErrors();
            $this->assertEquals($errors[0], 'User name is required.');
            $this->assertEquals($errors[1], 'Email is required.');
            $this->assertEquals($errors[2], 'Password is required.');
        }

    }


    public function testDatabaseValidateDataUser(){

        $service_provider = new ServiceProvider();
        $service_provider->setService('Development\UserModel');
        $newUser = new \Development\User($service_provider);

        $userdata = array(
            "email" => "jordicucala@hotmail.com",
            "password" => "pass",
            "user_name" =>"juan"
        );

        try {

            $data_base  = $this->getDatabaseConnection();

            $sql = "CREATE TABLE IF NOT EXISTS users(user_name text)";
            $data_base->query( $sql );

            $statement = "INSERT INTO users VALUES ('juan')";
            $data_base->query( $statement );


            $newUser->newUser($userdata);

            $errors = $newUser->getErrors();


            if( empty( $errors ) )
            {
                $this->assertTrue(True);
            }
            else{
                $this->assertTrue(False);
            }


        }
        catch(\InvalidArgumentException $e){

        }
    }


    public function testCheckUserOrigin(){
        $service_provider = new ServiceProvider();
        $service_provider->setService('Development\UserModel');
        $service_provider_mail = $this->getMock('Development\Mail');

        $fb_token = array(
            "valid_token" =>"True"
        );

        $service_provider_fb = $this->getMock('Development\FacebookAdapter');
        $service_provider_fb->expects($this->any())
            ->method('getFacebookData')
            ->will($this->returnValueMap($fb_token));


        $service_provider->setService('Development\FacebookAdapter',$service_provider_fb);
        $service_provider->setService('Development\Mail',$service_provider_mail);



        $newUser = new \Development\User($service_provider);

        $userdata = array(
            "email" => "jordicucala@hotmail.com",
            "password" => "pass",
            "user_name" =>"anton",
            "origin" =>"facebook"
        );

        try {


            $newUser->newUser($userdata);

        }
        catch(\InvalidArgumentException $e){
            var_dump($newUser->getErrors());
        }
    }


    public function getDatabaseConnection()
    {
        try
        {
            $data_base = new \PDO( "mysql:host=127.0.0.1;dbname=desarrollo", 'root', '' );
            $data_base->setAttribute( \PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC );
        } catch ( \PDOException $e )
        {
            throw new \RuntimeException( 'Database is down', 10 );
        }

        return $data_base;
    }







}