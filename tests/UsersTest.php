<?php

include_once __DIR__ . '/../src/Users.php';

class UsersTest extends PHPUnit_Framework_TestCase{

    protected static $newUser;

    /**
     *  Called before the first test of the test case class is run
     */
    public static function setUpBeforeClass(){
        self::$newUser = new Users();
        self::$newUser->createTable();
    }

    public function providerUser(){
        $users = array(
            array('jordi','12313123'),
            array('pepe','11233123'),
            array('juan','000999994'),
        );

        return $users;
    }
    /**
     * @param $newUser
     * @param $password
     * @dataProvider providerUser
     */
    public function testInsertUser($newUser,$password){
        $result = self::$newUser->insertUser($newUser,$password);
        $this->assertSame(true,$result);
    }

    /**
     * Test insert Action to user
     */
    public function testInsertUserAction(){
        $id = 1;
        $action = 10;

        $result = self::$newUser->insertUser($id,$action);
        $this->assertSame(true,$result);
    }

    /**
     * Test to get Actions of user
     * @param $id
     */
    public function testGetUserActions(){

        $id = 1;
        $action = self::$newUser->getUserActions($id);
        $this->assertNotEmpty($action);

    }
}