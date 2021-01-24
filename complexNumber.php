<?php

class ComplexNumber
{
    /**
     * Действительная часть комплексного числа
     * @var
     */
    private $real;

    /**
     * Мнимая часть комплексного числа
     * @var
     */
    private $imaginary;

    /**
     * Модуль комплексного числа
     * @var
     */
    private $module;

    /**
     * Аргумент комплексного числа (в радианах)
     * @var
     */
    private $argument;

    /**
     * ComplexNumber constructor.
     * @param $real
     * @param $imaginary
     * @param int $module
     * @param int $argument
     */
    public function __construct($real, $imaginary, $module = 0, $argument = 0)
    {
        $this->real = $real;
        $this->imaginary = $imaginary;
        $this->module = $module;
        $this->argument = $argument;
    }

    /**
     * Метод возвращает true, если комплексное число в алгебраической форме и false - если в тригонометрической форме
     * @return bool
     */
    private function isAlgebraicForm()
    {
        return ($this->real != 0 || $this->imaginary != 0);
    }

    /**
     * Метод возвращает действительную часть комплексного числа
     * @return mixed
     */
    public function getReal()
    {
        if ($this->isAlgebraicForm())
            return $this->real;
        else
            return $this->module * cos($this->argument);
    }

    /**
     * Метод возвращает мнимую часть комплексного числа
     * @return mixed
     */
    public function getImaginary()
    {
        if ($this->isAlgebraicForm())
            return $this->imaginary;
        else
            return $this->module * sin($this->argument);
    }

    /**
     * Метод возвращает модуль комплексного числа
     * @return float|int
     */
    public function getModule()
    {
        if ($this->isAlgebraicForm())
            return sqrt($this->real * $this->real + $this->imaginary * $this->imaginary);
        else
            return $this->module;
    }

    /**
     * Метод возвращает аргумент комплексного числа
     * @return float|int
     */
    public function getArgument()
    {
        if ($this->isAlgebraicForm())
        {
            try
            {
                return atan($this->imaginary / $this->real);
            }
            catch(Exception $ex)
            {
                echo '<br>Деление на 0!<br>';
                echo $ex->getMessage();
            }
        }
        else
            return $this->argument;
    }

    /**
     * Метод сложения
     * @param $complexNumber
     * @return ComplexNumber
     */
    public function add($complexNumber)
    {
        if ($this->isAlgebraicForm())
            return new ComplexNumber($this->real + $complexNumber->getReal(),
                $this->imaginary + $complexNumber->getImaginary());
        else
        {
            $moduleComplexNumber = $complexNumber->getModule();
            $argumentComplexNumber = $complexNumber->getArgument();
            $addComplexNumber = new ComplexNumber($this->module * cos($this->argument) + $moduleComplexNumber * cos($argumentComplexNumber),
                $this->module * sin($this->argument) + $moduleComplexNumber * sin($argumentComplexNumber));
            return new ComplexNumber(0, 0, $addComplexNumber->getModule(), $addComplexNumber->getArgument());
        }
    }

    /**
     * Метод вычитания
     * @param $complexNumber
     * @return ComplexNumber
     */
    public function subtract($complexNumber)
    {
        if ($this->isAlgebraicForm())
            return new ComplexNumber($this->real - $complexNumber->getReal(),
                $this->imaginary - $complexNumber->getImaginary());
        else
        {
            $moduleComplexNumber = $complexNumber->getModule();
            $argumentComplexNumber = $complexNumber->getArgument();
            $subtractComplexNumber = new ComplexNumber($this->module * cos($this->argument) - $moduleComplexNumber * cos($argumentComplexNumber),
                $this->module * sin($this->argument) - $moduleComplexNumber * sin($argumentComplexNumber));
            return new ComplexNumber(0, 0, $subtractComplexNumber->getModule(), $subtractComplexNumber->getArgument());
        }
    }

    /**
     * Метод умножения
     * @param $complexNumber
     * @return ComplexNumber
     */
    public function multiply($complexNumber)
    {
        if ($this->isAlgebraicForm())
        {
            $realComplexNumber = $complexNumber->getReal();
            $imaginaryComplexNumber = $complexNumber->getImaginary();
            return new ComplexNumber(
                $this->real * $realComplexNumber - $this->imaginary * $imaginaryComplexNumber,
                $this->real * $imaginaryComplexNumber + $this->imaginary * $realComplexNumber
            );
        }
        else
        {
            return new ComplexNumber(0, 0, $this->module * $complexNumber->getModule(),
                $this->argument + $complexNumber->getArgument());
        }
    }

    /**
     * Метод деления
     * @param $complexNumber
     * @return ComplexNumber
     */
    public function divide($complexNumber)
    {
        if ($this->isAlgebraicForm())
        {
            $realComplexNumber = $complexNumber->getReal();
            $imaginaryComplexNumber = $complexNumber->getImaginary();

            try
            {
                $realNewComplexNumber = ($this->real * $realComplexNumber + $this->imaginary * $imaginaryComplexNumber) /
                    ($realComplexNumber * $realComplexNumber + $imaginaryComplexNumber * $imaginaryComplexNumber);
                $imaginaryNewComplexNumber = ($this->imaginary * $realComplexNumber - $this->real * $imaginaryComplexNumber) /
                    ($realComplexNumber * $realComplexNumber + $imaginaryComplexNumber * $imaginaryComplexNumber);

                return new ComplexNumber($realNewComplexNumber, $imaginaryNewComplexNumber);
            }
            catch(Exception $ex)
            {
                echo '<br>Деление на 0!<br>';
                echo $ex->getMessage();
            }
        }
        else
        {
            try
            {
                return new ComplexNumber(0, 0, $this->module / $complexNumber->getModule(),
                    $this->argument - $complexNumber->getArgument());
            }
            catch(Exception $ex)
            {
                echo '<br>Деление на 0!<br>';
                echo $ex->getMessage();
            }
        }
    }
}

//$firstNumber = new ComplexNumber(3, 4);
$secondNumber = new ComplexNumber(1, 2);


$firstNumber = new ComplexNumber(0, 0, 5, 0.92729521800161);
//$secondNumber = new ComplexNumber(0, 0, 2.2360679774998, 1.1071487177941);

echo '<pre>';
print_r($firstNumber);
print_r($secondNumber);
echo '</pre>';


echo 'Первое комплексное число:<br>';
echo 'Алгебраическая форма firstNumber = ' . $firstNumber->getReal() . ($firstNumber->getImaginary() > 0 ? '+' : '') .
    $firstNumber->getImaginary() . 'i' . '<br>';
echo 'Тригонометрическая форма firstNumber = ' . $firstNumber->getModule() . '*(cos(' . $firstNumber->getArgument() .
    ')+sin(' . $firstNumber->getArgument() . ')i' . '<br><br>';

echo 'Второе комплексное число:<br>';
echo 'Алгебраическая форма secondNumber = ' . $secondNumber->getReal() . ($secondNumber->getImaginary() > 0 ? '+' : '') .
    $secondNumber->getImaginary() . 'i' . '<br>';
echo 'Тригонометрическая форма secondNumber = ' . $secondNumber->getModule() . '*(cos(' . $secondNumber->getArgument() .
    ')+sin(' . $secondNumber->getArgument() . ')i' . '<br><br>';

echo '<br>Операция сложения:<br>';
$a = $firstNumber->add($secondNumber);
echo 'Алгебраическая форма firstNumber + secondNumber = ' . $a->getReal() . ($a->getImaginary() > 0 ? '+' : '') . $a->getImaginary() . 'i' . '<br>';
echo 'Тригонометрическая форма firstNumber + secondNumber = ' . $a->getModule() . '*(cos(' . $a->getArgument() .
    ')+sin(' . $a->getArgument() . ')i' . '<br>';
$b = $secondNumber->add($firstNumber);
echo 'Алгебраическая форма secondNumber + firstNumber = ' . $b->getReal() . ($b->getImaginary() > 0 ? '+' : '') . $b->getImaginary() . 'i' . '<br>';
echo 'Тригонометрическая форма secondNumber + firstNumber = ' . $b->getModule() . '*(cos(' . $b->getArgument() .
    ')+sin(' . $b->getArgument() . ')i' . '<br>';

echo '<br>Операция вычитания:<br>';
$c = $firstNumber->subtract($secondNumber);
echo 'Алгебраическая форма firstNumber - secondNumber = ' . $c->getReal() . ($c->getImaginary() > 0 ? '+' : '') . $c->getImaginary() . 'i' . '<br>';
echo 'Тригонометрическая форма firstNumber - secondNumber = ' . $c->getModule() . '*(cos(' . $c->getArgument() .
    ')+sin(' . $c->getArgument() . ')i' . '<br>';
$d = $secondNumber->subtract($firstNumber);
echo 'Алгебраическая форма secondNumber - firstNumber = ' . $d->getReal() . ($d->getImaginary() > 0 ? '+' : '') . $d->getImaginary() . 'i' . '<br>';
echo 'Тригонометрическая форма secondNumber - firstNumber = ' . $d->getModule() . '*(cos(' . $d->getArgument() .
    ')+sin(' . $d->getArgument() . ')i' . '<br>';

echo '<br>Операция умножения:<br>';
$e = $firstNumber->multiply($secondNumber);
echo 'Алгебраическая форма firstNumber * secondNumber = ' . $e->getReal() . ($e->getImaginary() > 0 ? '+' : '') . $e->getImaginary() . 'i' . '<br>';
echo 'Тригонометрическая форма firstNumber * secondNumber = ' . $e->getModule() . '*(cos(' . $e->getArgument() .
    ')+sin(' . $e->getArgument() . ')i' . '<br>';
$f = $secondNumber->multiply($firstNumber);
echo 'Алгебраическая форма secondNumber * firstNumber = ' . $f->getReal() . ($f->getImaginary() > 0 ? '+' : '') . $f->getImaginary() . 'i' . '<br>';
echo 'Тригонометрическая форма secondNumber * firstNumber = ' . $f->getModule() . '*(cos(' . $f->getArgument() .
    ')+sin(' . $f->getArgument() . ')i' . '<br>';

echo '<br>Операция деления:<br>';
$g = $firstNumber->divide($secondNumber);
echo 'Алгебраическая форма firstNumber / secondNumber = ' . $g->getReal() . ($g->getImaginary() > 0 ? '+' : '') . $g->getImaginary() . 'i' . '<br>';
echo 'Тригонометрическая форма firstNumber / secondNumber = ' . $g->getModule() . '*(cos(' . $g->getArgument() .
    ')+sin(' . $g->getArgument() . ')i' . '<br>';
$h = $secondNumber->divide($firstNumber);
echo 'Алгебраическая форма secondNumber / firstNumber = ' . $h->getReal() . ($h->getImaginary() > 0 ? '+' : '') . $h->getImaginary() . 'i' . '<br>';
echo 'Тригонометрическая форма secondNumber / firstNumber = ' . $h->getModule() . '*(cos(' . $h->getArgument() .
    ')+sin(' . $h->getArgument() . ')i' . '<br>';
