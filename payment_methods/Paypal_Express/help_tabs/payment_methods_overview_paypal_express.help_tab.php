<p>
	<strong><?php _e( 'PayPal Express Checkout', 'event_espresso' ); ?></strong>
</p>
<p>
	<?php _e('Adjust the settings for the PayPal Express Checkout.', 'event_espresso'); ?>
</p>
<p>
	<a target="_blank" href="https://eventespresso.com/go/paypalstandard/"><?php _e('Click here to signup for an account with PayPal', 'event_espresso'); ?></a>
</p>

<p>
	<strong><?php _e('PayPal Express Checkout Settings', 'event_espresso'); ?></strong>
</p>
<ul>
	<li>
		<strong><?php _e( 'API Username', 'event_espresso' ); ?></strong><br/>
		<?php _e( 'Your PayPal API Username.'); ?>
	</li>
	<li>
		<strong><?php _e( 'API Password', 'event_espresso' ); ?></strong><br/>
		<?php _e( 'Your PayPal API Password.' ); ?>
	</li>
	<li>
		<strong><?php _e( 'API Signature', 'event_espresso' ); ?></strong><br/>
		<?php _e( 'Your PayPal Account Signature.' ); ?>
	</li>
</ul>
<p>
	<?php printf( __('For testing please use a %1$s PaypPal Sandbox account%2$s.', 'event_espresso'), '<a target="_blank" href="https://developer.paypal.com">', '</a>' ); ?>
</p>
<p>
	<?php printf( __('%1$sClick here%2$s for more information on how to get your API credentials.', 'event_espresso'), '<a target="_blank" href="https://developer.paypal.com/docs/classic/api/apiCredentials/?mark=api%20signature#creating-an-api-signature">', '</a>' ); ?>
</p>