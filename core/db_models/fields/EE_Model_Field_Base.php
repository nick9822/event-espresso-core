<?php if (! defined('EVENT_ESPRESSO_VERSION')) {
    exit('No direct script access allowed');
}

/**
 * EE_Model_Field_Base class
 * Base class for all EE_*_Field classes. These classes are for providing information and functions specific to each
 * field. They define the field's data type for insertion into the db (eg, if the value should be treated as an int,
 * float, or string), what values for the field are acceptable (eg, if setting EVT_ID to a float is acceptable), and
 * generally any functionality within EEM_Base or EE_Base_Class which depend on the field's type. (ie, you shouldn't
 * need any logic within your model or model object which are dependent on the field's type, ideally). For example,
 * EE_Serialized_Text_Field, specifies that any fields of this type should be serialized before insertion into the db
 * (prepare_for_insertion_into_db()), should be considered a string when inserting, updating, or using in a where
 * clause for any queries (get_wpdb_data_type()), should be unserialized when being retrieved from the db
 * (prepare_for_set_from_db()), and whatever else.
 *
 * @package               Event Espresso
 * @subpackage            /core/db_models/fields/EE_Model_Field_Base.php
 * @author                Michael Nelson
 */
abstract class EE_Model_Field_Base
{
    /**
     * The alias for the table the column belongs to.
     * @var string
     */
    protected $_table_alias;

    /**
     * The actual db column name for the table
     * @var string
     */
    protected $_table_column;


    /**
     * The authoritative name for the table column (used by client code to reference the field).
     * @var string
     */
    protected $_name;


    /**
     * A description for the field.
     * @var string
     */
    protected $_nicename;


    /**
     * Whether the field is nullable or not
     * @var bool
     */
    protected $_nullable;


    /**
     * What the default value for the field should be.
     * @var mixed
     */
    protected $_default_value;


    /**
     * Other configuration for the field
     * @var mixed
     */
    protected $_other_config;


    /**
     * The name of the model this field is instantiated for.
     * @var string
     */
    protected $_model_name;

    /**
     * @param      $table_column
     * @param      $nicename
     * @param      $nullable
     * @param null $default_value
     */
    public function __construct($table_column, $nicename, $nullable, $default_value = null)
    {
        $this->_table_column  = $table_column;
        $this->_nicename      = $nicename;
        $this->_nullable      = $nullable;
        $this->_default_value = $default_value;
    }


    /**
     * @param $table_alias
     * @param $name
     * @param $model_name
     */
    public function _construct_finalize($table_alias, $name, $model_name)
    {
        $this->_table_alias = $table_alias;
        $this->_name        = $name;
        $this->_model_name  = $model_name;
        /**
         * allow for changing the defaults
         */
        $this->_nicename      = apply_filters('FHEE__EE_Model_Field_Base___construct_finalize___nicename',
            $this->_nicename, $this);
        $this->_default_value = apply_filters('FHEE__EE_Model_Field_Base___construct_finalize___default_value',
            $this->_default_value, $this);
    }

    public function get_table_alias()
    {
        return $this->_table_alias;
    }

    public function get_table_column()
    {
        return $this->_table_column;
    }

    /**
     * Returns the name of the model this field is on. Eg 'Event' or 'Ticket_Datetime'
     *
     * @return string
     */
    public function get_model_name()
    {
        return $this->_model_name;
    }

    /**
     * @throws \EE_Error
     * @return string
     */
    public function get_name()
    {
        if ($this->_name) {
            return $this->_name;
        } else {
            throw new EE_Error(sprintf(__("Model field '%s' has no name set. Did you make a model and forget to call the parent model constructor?",
                "event_espresso"), get_class($this)));
        }
    }

    public function get_nicename()
    {
        return $this->_nicename;
    }

    public function is_nullable()
    {
        return $this->_nullable;
    }

    /**
     * returns whether this field is an auto-increment field or not. If it is, then
     * on insertion it can be null. However, on updates it must be present.
     *
     * @return boolean
     */
    public function is_auto_increment()
    {
        return false;
    }

    /**
     * The default value in the model object's value domain. See lengthy comment about
     * value domains at the top of EEM_Base
     *
     * @return mixed
     */
    public function get_default_value()
    {
        return $this->_default_value;
    }

    /**
     * Returns the table alias joined to the table column, however this isn't the right
     * table alias if the aliased table is being joined to. In that case, you can use
     * EE_Model_Parser::extract_table_alias_model_relation_chain_prefix() to find the table's current alias
     * in the current query
     *
     * @return string
     */
    public function get_qualified_column()
    {
        return $this->get_table_alias() . "." . $this->get_table_column();
    }

    /**
     * When get() is called on a model object (eg EE_Event), before returning its value,
     * call this function on it, allowing us to customize the returned value based on
     * the field's type. Eg, we may want ot serialize it, strip tags, etc. By default,
     * we simply return it.
     *
     * @param mixed $value_of_field_on_model_object
     * @return mixed
     */
    public function prepare_for_get($value_of_field_on_model_object)
    {
        return $value_of_field_on_model_object;
    }

    /**
     * When inserting or updating a field on a model object, run this function on each
     * value to prepare it for insertion into the db. We may want to add slashes, serialize it, etc.
     * By default, we do nothing.
     *
     * @param mixed $value_of_field_on_model_object
     * @return mixed
     */
    public function prepare_for_use_in_db($value_of_field_on_model_object)
    {
        return $value_of_field_on_model_object;
    }

    /**
     * When creating a brand-new model object, or setting a particular value for one of its fields, this function
     * is called before setting it on the model object. We may want to strip slashes, unserialize the value, etc.
     * By default, we do nothing.
     *
     * @param mixed $value_inputted_for_field_on_model_object
     * @return mixed
     */
    public function prepare_for_set($value_inputted_for_field_on_model_object)
    {
        return $value_inputted_for_field_on_model_object;
    }


    /**
     * When instantiating a model object from DB results, this function is called before setting each field.
     * We may want to serialize the value, etc. By default, we return the value using prepare_for_set() method as that
     * is the one child classes will most often define.
     *
     * @param mixed $value_found_in_db_for_model_object
     * @return mixed
     */
    public function prepare_for_set_from_db($value_found_in_db_for_model_object)
    {
        return $this->prepare_for_set($value_found_in_db_for_model_object);
    }

    /**
     * When echoing a field's value on a model object, this function is run to prepare the value for presentation in a
     * webpage. For example, we may want to output floats with 2 decimal places by default, dates as "Monday Jan 12,
     * 2013, at 3:23pm" instead of
     * "8765678632", or any other modifications to how the value should be displayed, but not modified itself.
     *
     * @param mixed $value_on_field_to_be_outputted
     * @return mixed
     */
    public function prepare_for_pretty_echoing($value_on_field_to_be_outputted)
    {
        return $value_on_field_to_be_outputted;
    }

    /**
     * Return `%d`, `%s` or `%f` to indicate the data type for the field.
     * @return string
     */
    abstract function get_wpdb_data_type();


    /**
     * This returns elements used to represent this field in the json schema.
     *
     * @link http://json-schema.org/
     * @return array
     */
    abstract public function get_schema();

    /**
     * Some fields are in the database-only, (ie, used in queries etc), but shouldn't necessarily be part
     * of the model objects (ie, client code shouldn't care to ever see their value... if client code does
     * want to see their value, then they shouldn't be db-only fields!)
     * Eg, when doing events as custom post types, querying the post_type is essential, but
     * post_type is irrelevant for EE_Event objects (because they will ALL be of post_type 'esp_event').
     * By default, all fields aren't db-only.
     *
     * @return boolean
     */
    public function is_db_only_field()
    {
        return false;
    }
}