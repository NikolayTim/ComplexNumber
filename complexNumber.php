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
     * ComplexNumber constructor.
     * @param $real
     * @param $imaginary
     */
    public function __construct($real, $imaginary)
    {
        $this->real = $real;
        $this->imaginary = $imaginary;
    }

    /**
     * Метод возвращает действительную часть комплексного числа
     * @return mixed
     */
    public function getReal()
    {
        return $this->real;
    }

    /**
     * Метод возвращает мнимую часть комплексного числа
     * @return mixed
     */
    public function getImaginary()
    {
        return $this->imaginary;
    }

    /**
     * Метод сложения
     * @param $complexNumber
     * @return ComplexNumber
     */
    public function add($complexNumber)
    {
        return new ComplexNumber($this->real + $complexNumber->getReal(), $this->imaginary + $complexNumber->getImaginary());
    }

    /**
     * Метод вычитания
     * @param $complexNumber
     * @return ComplexNumber
     */
    public function subtract($complexNumber)
    {
        return new ComplexNumber($this->real - $complexNumber->getReal(), $this->imaginary - $complexNumber->getImaginary());
    }

    /**
     * Метод умножения
     * @param $complexNumber
     * @return ComplexNumber
     */
    public function multiply($complexNumber)
    {
        $realComplexNumber = $complexNumber->getReal();
        $imaginaryComplexNumber = $complexNumber->getImaginary();
        return new ComplexNumber(
            $this->real * $realComplexNumber - $this->imaginary * $imaginaryComplexNumber,
            $this->real * $imaginaryComplexNumber + $this->imaginary * $realComplexNumber
        );
    }

    /**
     * Метод деления
     * @param $complexNumber
     * @return ComplexNumber
     */
    public function divide($complexNumber)
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
}


$firstNumber = new ComplexNumber(3, 4);
$secondNumber = new ComplexNumber(1, 2);

echo 'Первое комплексное число: firstNumber = ' . $firstNumber->getReal() . ($firstNumber->getImaginary() > 0 ? '+' : '') .
    $firstNumber->getImaginary() . 'i' . '<br>';
echo 'Второе комплексное число: secondNumber = ' . $secondNumber->getReal() . ($secondNumber->getImaginary() > 0 ? '+' : '') .
    $secondNumber->getImaginary() . 'i' . '<br>';

echo '<br>Операция сложения:<br>';
$a = $firstNumber->add($secondNumber);
echo 'firstNumber + secondNumber = ' . $a->getReal() . ($a->getImaginary() > 0 ? '+' : '') . $a->getImaginary() . 'i' . '<br>';
$b = $secondNumber->add($firstNumber);
echo 'secondNumber + firstNumber = ' . $b->getReal() . ($b->getImaginary() > 0 ? '+' : '') . $b->getImaginary() . 'i' . '<br>';

echo '<br>Операция вычитания:<br>';
$c = $firstNumber->subtract($secondNumber);
echo 'firstNumber - secondNumber = ' . $c->getReal() . ($c->getImaginary() > 0 ? '+' : '') . $c->getImaginary() . 'i' . '<br>';
$d = $secondNumber->subtract($firstNumber);
echo 'secondNumber - firstNumber = ' . $d->getReal() . ($d->getImaginary() > 0 ? '+' : '') . $d->getImaginary() . 'i' . '<br>';

echo '<br>Операция умножения:<br>';
$e = $firstNumber->multiply($secondNumber);
echo 'firstNumber * secondNumber = ' . $e->getReal() . ($e->getImaginary() > 0 ? '+' : '') . $e->getImaginary() . 'i' . '<br>';
$f = $secondNumber->multiply($firstNumber);
echo 'secondNumber * firstNumber = ' . $f->getReal() . ($f->getImaginary() > 0 ? '+' : '') . $f->getImaginary() . 'i' . '<br>';

echo '<br>Операция деления:<br>';
$g = $firstNumber->divide($secondNumber);
echo 'firstNumber / secondNumber = ' . $g->getReal() . ($g->getImaginary() > 0 ? '+' : '') . $g->getImaginary() . 'i' . '<br>';
$h = $secondNumber->divide($firstNumber);
echo 'secondNumber / firstNumber = ' . $h->getReal() . ($h->getImaginary() > 0 ? '+' : '') . $h->getImaginary() . 'i' . '<br>';
