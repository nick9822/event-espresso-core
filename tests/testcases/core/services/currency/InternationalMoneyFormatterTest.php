<?php
use EventEspresso\core\services\currency\formatters\InternationalMoneyFormatter;
use EventEspresso\core\services\loaders\LoaderFactory;

defined('EVENT_ESPRESSO_VERSION') || exit;



/**
 * Class InternationalMoneyFormatterTest
 * Description
 *
 * @package       Event Espresso
 * @author        Brent Christensen
 * @since         $VID:$
 * @group 10619
 */
class InternationalMoneyFormatterTest extends \EE_UnitTestCase
{

    /**
     * @group Money
     */
    public function test_format()
    {
        $currency_factory = LoaderFactory::getLoader()->getShared(
            'EventEspresso\core\services\currency\CurrencyFactory'
        );
        $currency = $currency_factory->createFromCountryCode('US');
        $formatter = new InternationalMoneyFormatter();
        $this->assertEquals(
            $formatter->format(1234.5, $currency),
            '1234.5 <span class="currency-code">(USD)</span>'
        );
    }
}
// End of file DecimalMoneyFormatterTest.php
// Location: tests/testcases/core/services/currency/InternationalMoneyFormatterTest.php