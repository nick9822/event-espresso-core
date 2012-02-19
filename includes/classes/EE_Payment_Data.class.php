<?php

class PaymentData {

	// Set in constructor. The primary attendee's id.
	public $attendee_id;
	// attendee specific info
	public $email;
	public $registration_id;
	public $attendee_session;
	public $lname;
	public $fname;
	public $contact;
	public $address;
	public $city;
	public $zip;
	public $state;
	public $phone;
	// event specfic info
	public $start_date;
	public $event_name;
	public $event_id;
	public $require_pre_approval;
	public $event_link;
	//cost related info
	public $total_cost;
	public $quantity;
	public $discount_applied;
	public $pre_discount_cost;
	public $tickets;
// This one is also set using filter_hook_espresso_prepare_payment_data_for_gateways
	// because they are used to store information neccessary to secure confirmation of payment
	// It is reset after the individual gateways by espresso_update_attendee_payment_status_in_db
	public $payment_date;
	// These are the ones that every individual gateway MUST set
	// txn_id is also used by some gateways to store information neccessary to secure confirmation
	// of payment, and is thus pulled by filter_hook_espresso_prepare_payment_data_for_gateways
	public $txn_id;
	public $payment_status;
	public $txn_details;
	public $txn_type;

	public function __construct($attendee_id) {
		$this->attendee_id = $attendee_id;
	}

	public function populate_data_from_db() {
		global $wpdb, $org_options;
		$sql = "SELECT ea.email, ea.registration_id, ea.txn_type,";
		$sql .= " ea.attendee_session, ea.lname, ea.fname, ea.total_cost,";
		$sql .= "	ea.payment_status, ea.payment_date, ea.address, ea.city, ea.txn_id,";
		$sql .= " ea.zip, ea.state, ea.phone FROM " . EVENTS_ATTENDEE_TABLE . " ea";
		$sql .= " WHERE ea.id='" . $this->attendee_id . "'";
		$result = $wpdb->get_row($sql, ARRAY_A);
		if (empty($result)) do_action('action_hook_espresso_log', __FILE__, __FUNCTION__, $sql);
		extract($result);
		$this->contact = $org_options['contact_email'];
		$this->email = $email;
		$this->registration_id = $registration_id;
		$this->txn_type = $txn_type;
		$this->attendee_session = $attendee_session;
		$this->lname = $lname;
		$this->fname = $fname;
		$this->total_cost = $total_cost;
		$this->payment_status = $payment_status;
		$this->payment_date = $payment_date;
		$this->address = $address;
		$this->city = $city;
		$this->txn_id = $txn_id;
		$this->zip = $zip;
		$this->state = $state;
		$this->phone = $phone;
		$sql = "SELECT  ed.id, ed.event_name, ed.start_date, ed.require_pre_approval FROM " . EVENTS_ATTENDEE_TABLE . " ea";
		$sql .= " JOIN " . EVENTS_DETAIL_TABLE . " ed ON ed.id=ea.event_id";
		$sql .= " WHERE ea.attendee_session='" . $this->attendee_session . "'";
		$events = $wpdb->get_results($sql, OBJECT_K);
		foreach ($events as $event) {
			$this->event_id[] = $event->id;
			$this->event_name[] = $event->event_name;
			$this->start_date[] = $event->start_date;
			$this->require_pre_approval[] = $event->require_pre_approval;
			$event_url = espresso_reg_url($event->id);
			$this->event_link[] .= '<a href="' . $event_url . '">' . $event->event_name . '</a>';
		}
	}

	public function calculate_costs() {
		global $wpdb;
		$sql = "SELECT ac.cost, ac.quantity, dc.coupon_code_price, dc.use_percentage  FROM " . EVENTS_ATTENDEE_TABLE . " a ";
		$sql .= " JOIN " . EVENTS_ATTENDEE_COST_TABLE . " ac ON a.id=ac.attendee_id ";
		$sql .= " LEFT JOIN " . EVENTS_DISCOUNT_CODES_TABLE . " dc ON a.coupon_code=dc.coupon_code ";
		$sql .= " WHERE a.attendee_session='" . $this->attendee_session . "'";
		$tickets = $wpdb->get_results($sql, ARRAY_A);
		$total_cost = 0;
		$total_quantity = 0;
		foreach ($tickets as $ticket) {
			$total_cost += $ticket['quantity'] * $ticket['cost'];
			$total_quantity += $ticket['quantity'];
		}
		if (!empty($tickets[0]['coupon_code_price'])) {
			if ($tickets[0]['use_percentage'] == 'Y') {
				$this->total_cost = $total_cost * (1 - ($tickets[0]['coupon_code_price'] / 100));
			} else {
				$this->total_cost = max($total_cost - $tickets[0]['coupon_code_price'], 0);
			}
		} else {
			$this->total_cost = $total_cost;
		}
		$this->quantity = $total_quantity;
		$this->discount_applied = $total_cost - $this->total_cost;
		$this->pre_discount_cost = $total_cost;
		$this->tickets = $tickets;
	}

	public function write_payment_data_to_db() {
		global $wpdb;
		$sql = "UPDATE " . EVENTS_ATTENDEE_TABLE . " SET amount_pd = '" . $this->total_cost . "' WHERE id ='" . $this->attendee_id . "' ";
		$wpdb->query($sql);

		$sql = "UPDATE " . EVENTS_ATTENDEE_TABLE . " SET payment_status = '" . $this->payment_status . "', txn_type = '" . $this->txn_type . "', txn_id = '" . $this->txn_id . "', payment_date ='" . $this->payment_date . "', transaction_details = '" . $this->txn_details . "' WHERE attendee_session ='" . $this->attendee_session . "' ";
		$wpdb->query($sql);
	}

}

/**
 * function espresso_prepare_payment_data_for_gateways
 * @global type $wpdb
 * @global type $org_options
 * @param type $payment_data
 * attendee_id
 * @return type $payment_data
 * contact
 * email
 * event_id
 * registration_id
 * attendee_session
 * event_name
 * lname
 * fname
 * payment_status
 * payment_date
 */
function espresso_prepare_payment_data_for_gateways($payment_data) {
	global $wpdb, $org_options;
	$sql = "SELECT ea.email, ea.event_id, ea.registration_id, ea.txn_type, ed.start_date,";
	$sql .= " ea.attendee_session, ed.event_name, ea.lname, ea.fname, ea.total_cost,";
	$sql .= "	ea.payment_status, ea.payment_date, ea.address, ea.city, ea.txn_id,";
	$sql .= " ea.zip, ea.state, ea.phone FROM " . EVENTS_ATTENDEE_TABLE . " ea";
	$sql .= " JOIN " . EVENTS_DETAIL_TABLE . " ed ON ed.id=ea.event_id";
	$sql .= " WHERE ea.id='" . $payment_data['attendee_id'] . "'";
	$temp_data = $wpdb->get_row($sql, ARRAY_A);
	$payment_data = array_merge($payment_data, $temp_data);
	$payment_data['contact'] = $org_options['contact_email'];
	return $payment_data;
}

/**
 * function espresso_prepare_event_link
 * @param array $payment_data
 * attendee_session
 * @return array $payment_data
 * event_link
 */
function espresso_prepare_event_link($payment_data) {
	global $wpdb;
	$sql = "SELECT  ea.event_id, ed.event_name FROM " . EVENTS_ATTENDEE_TABLE . " ea";
	$sql .= " JOIN " . EVENTS_DETAIL_TABLE . " ed ON ed.id=ea.event_id";
	$sql .= " WHERE ea.attendee_session='" . $payment_data['attendee_session'] . "'";
	$events = $wpdb->get_results($sql, OBJECT_K);
	$payment_data['event_link'] = '';
	foreach ($events as $event) {
		$event_url = espresso_reg_url($event->event_id);
		$payment_data['event_link'] .= '<a href="' . $event_url . '">' . $event->event_name . '</a><br />';
	}
	$payment_data['payment_date'] = date_i18n(get_option('date_format'), time());
	return $payment_data;
}

/**
 * function espresso_get_total_cost
 * @global type $wpdb
 * @param array $payment_data
 * attendee_session
 * @return array $payment_data
 * pre_discount_cost
 * total_cost
 * quantity
 * discount_applied
 */
function espresso_get_total_cost($payment_data) {
	global $wpdb;
	$sql = "SELECT ac.cost, ac.quantity, dc.coupon_code_price, dc.use_percentage  FROM " . EVENTS_ATTENDEE_TABLE . " a ";
	$sql .= " JOIN " . EVENTS_ATTENDEE_COST_TABLE . " ac ON a.id=ac.attendee_id ";
	$sql .= " LEFT JOIN " . EVENTS_DISCOUNT_CODES_TABLE . " dc ON a.coupon_code=dc.coupon_code ";
	$sql .= " WHERE a.attendee_session='" . $payment_data['attendee_session'] . "'";
	$tickets = $wpdb->get_results($sql, ARRAY_A);
	$total_cost = 0;
	$total_quantity = 0;
	foreach ($tickets as $ticket) {
		$total_cost += $ticket['quantity'] * $ticket['cost'];
		$total_quantity += $ticket['quantity'];
	}
	if (!empty($tickets[0]['coupon_code_price'])) {
		if ($tickets[0]['use_percentage'] == 'Y') {
			$payment_data['total_cost'] = $total_cost * (1 - ($tickets[0]['coupon_code_price'] / 100));
		} else {
			$payment_data['total_cost'] = $total_cost - $tickets[0]['coupon_code_price'];
		}
	} else {
		$payment_data['total_cost'] = $total_cost;
	}
	$payment_data['quantity'] = $total_quantity;
	$payment_data['discount_applied'] = $total_cost - $payment_data['total_cost'];
	$payment_data['pre_discount_cost'] = $total_cost;
	$payment_data['tickets'] = $tickets;
	return $payment_data;
}

/**
 * function espresso_update_attendee_payment_status_in_db
 * @global type $wpdb
 * @param array $payment_data
 * attendee_id    set by function in individual gateway
 * attendee_session  set by filter_hook_espresso_prepare_payment_data_for_gateways
 * total_cost     set by filter_hook_espresso_get_total_cost
 *                 the rest are set by gateway
 * payment_status
 * txn_type
 * txn_id
 * txn_details
 *
 * @return array $payment_data
 * payment_date
 */
function espresso_update_attendee_payment_status_in_db($payment_data) {
	global $wpdb;
	$sql = "UPDATE " . EVENTS_ATTENDEE_TABLE . " SET amount_pd = '" . $payment_data['total_cost'] . "' WHERE id ='" . $payment_data['attendee_id'] . "' ";
	$wpdb->query($sql);

	$sql = "UPDATE " . EVENTS_ATTENDEE_TABLE . " SET payment_status = '" . $payment_data['payment_status'] . "', txn_type = '" . $payment_data['txn_type'] . "', txn_id = '" . $payment_data['txn_id'] . "', payment_date ='" . $payment_data['payment_date'] . "', transaction_details = '" . $payment_data['txn_details'] . "' WHERE attendee_session ='" . $payment_data['attendee_session'] . "' ";
	$wpdb->query($sql);
	return $payment_data;
}
