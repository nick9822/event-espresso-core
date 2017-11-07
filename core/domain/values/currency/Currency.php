<?php

namespace EventEspresso\core\domain\values\currency;

use EventEspresso\core\entities\Label;

defined('EVENT_ESPRESSO_VERSION') || exit;



/**
 * Class Currency
 * DTO for data pertaining to a currency
 *
 * @package       Event Espresso
 * @author        Brent Christensen
 * @since         $VID:$
 */
class Currency
{

    /**
     * eg 'US'
     *
     * @var string $code
     */
    private $code;

    /**
     * @var Label $label
     */
    private $label;

    /**
     * currency sign
     *
     * @var string $sign
     * eg '$'
     */
    private $sign;

    /**
     * Whether the currency sign should come before the number or not
     *
     * @var boolean $sign_b4
     */
    private $sign_b4;

    /**
     * How many digits should come after the decimal place
     *
     * @var int $decimal_places
     */
    private $decimal_places;

    /**
     * Symbol to use for decimal mark
     *
     * @var string $decimal_mark
     * eg '.'
     */
    private $decimal_mark;

    /**
     * Symbol to use for thousands
     *
     * @var string $thousands
     * eg ','
     */
    private $thousands;



    /**
     * Currency constructor.
     *
     * @param string $code
     * @param Label  $label
     * @param string $sign
     * @param bool   $sign_b4
     * @param int    $decimal_places
     * @param string $decimal_mark
     * @param string $thousands
     */
    public function __construct($code, Label $label, $sign, $sign_b4, $decimal_places, $decimal_mark, $thousands)
    {
        $this->code           = $code;
        $this->label          = $label;
        $this->sign           = $sign;
        $this->sign_b4        = $sign_b4;
        $this->decimal_places = $decimal_places;
        $this->decimal_mark   = $decimal_mark;
        $this->thousands      = $thousands;
    }



    /**
     * returns true if this currency is the same as the supplied currency
     *
     * @param Currency $other
     * @return bool
     */
    public function equals(Currency $other)
    {
        return $this->code() === $other->code();
    }



    /**
     * @return string
     */
    public function code()
    {
        return $this->code;
    }



    /**
     * @return string
     */
    public function name()
    {
        return $this->label->singular();
    }



    /**
     * @return string
     */
    public function plural()
    {
        return $this->label->plural();
    }



    /**
     * @return string
     */
    public function sign()
    {
        return $this->sign;
    }



    /**
     * @return bool
     */
    public function signB4()
    {
        return $this->sign_b4;
    }



    /**
     * @return int
     */
    public function decimalPlaces()
    {
        return $this->decimal_places;
    }



    /**
     * @return string
     */
    public function decimalMark()
    {
        return $this->decimal_mark;
    }



    /**
     * @return string
     */
    public function thousands()
    {
        return $this->thousands;
    }



    /**
     * @return string
     */
    public function __toString()
    {
        return $this->code();
    }



}
// End of file Currency.php
// Location: core/entities/money/Currency.php
