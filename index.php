<?php

// 7.2 - 7.4
// typehinting - public !INT/STRING! $age = 18;

// int
// string
// array
// object
// self - сам себя
// null - 0
// void - ничего

class User
{
    //свойства
    private int $userAge = 25;
    private int $height = 180;
    private int $weight = 65;
    protected string $name = 'Aleksei';
    protected string $surname = 'Sokolov';
    private string $job = 'no job';

    //методы
    public function getAge(): int // геттер
    {
        return $this->userAge;
    }
    public function setAge(int $newAge /*, string $name */) // сеттер
    {
        $this->userAge = $newAge;
    }
}

class Teacher extends User
{
    protected string $job = 'teacher';
    public function sayHelloToStudents()
    {
        echo
        sprintf("Hello, my name is %s %s. I'm %s.",
            $this->name,
            $this->name,
            $this->job);
            // $saySting = "Hello, my name is %s %s. I'm %s.";
            // echo sprintf($saySting, $this->name, $this->name, $this->job);
    }
}

class Student extends User
{
    protected string $job = 'student';
}

$teacher = new Teacher();
$student = new Student();

$teacher->setAge(86). '<br>';
echo $teacher->getAge() . '<br>';
echo $teacher->sayHelloToStudents() . '<br>';

// echo $teacher->job . '<br>';
// echo $student->job;

// $user = new User();
// echo $user->age;

