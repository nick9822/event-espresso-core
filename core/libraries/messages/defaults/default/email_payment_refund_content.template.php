<table class="head-wrap" bgcolor="#999999">
	<tbody>
		<tr>
			<td></td>
			<td class="header container">
				<div class="content">
					<table bgcolor="#999999">
						<tbody>
							<tr>
								<td>[CO_LOGO]</td>
								<td align="right">
									<h6 class="collapse">[COMPANY]</h6>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</td>
			<td></td>
		</tr>
	</tbody>
</table>

<table class="body-wrap">
	<tbody>
		<tr>
			<td></td>
			<td class="container" bgcolor="#FFFFFF">
				<div class="content">
					<table>
						<tbody>
							<tr>
								<td>
									<h2><?php printf( __( 'Hello, %s:', 'event_espresso' ), '[PRIMARY_REGISTRANT_FNAME] [PRIMARY_REGISTRANT_LNAME]' ); ?></h2>
									<p class="lead"><?php _e( "We're just notifying you of a refund issued for the following transaction and tickets:", 'event_espresso' ); ?></p>
									<h3><?php _e( 'Refund Details:', 'event_espresso' ); ?></h3>
									<ul>
										<li>
											<strong><?php _e( 'Payment Status:', 'event_espresso' ); ?></strong> [PAYMENT_STATUS]
										</li>
										<li>
											<strong><?php _e( 'Transaction ID:', 'event_espresso' ); ?></strong> [TXN_ID]
										</li>
										<li>
											<strong><?php _e( 'Total Cost:', 'event_espresso' ); ?></strong> [TOTAL_COST]
										</li>
										<li>
											<strong><?php _e( 'Refund Amount:', 'event_espresso' ); ?></strong> [AMOUNT_PAID]
										</li>
									</ul>
									[EVENT_LIST]
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</td>
			<td></td>
		</tr>
	</tbody>
</table>

<table class="footer-wrap">
	<tbody>
		<tr>
			<td class="container">
				<table class="social" width="100%">
					<tbody>
						<tr>
							<td>
								<table class="column" align="left">
									<tbody>
										<tr>
											<td>
												<h3><?php _e( 'Connect with Us:', 'event_espresso' ); ?></h3>
												<a class="soc-btn fb" href="[CO_FACEBOOK_URL]"><?php _e( 'Facebook', 'event_espresso' ); ?></a>
												<a class="soc-btn tw" href="[CO_TWITTER_URL]"><?php _e( 'Twitter', 'event_espresso' ); ?></a>
												<a class="soc-btn gp" href="[CO_GOOGLE_URL]"><?php _e( 'Google+', 'event_espresso' ); ?></a>
											</td>
										</tr>
									</tbody>
								</table>

								<table class="column" align="left">
									<tbody>
										<tr>
											<td>
												<h3><?php _e( 'Contact Info:', 'event_espresso' ); ?></h3>
												<?php _e( 'Phone:', 'event_espresso' ); ?> <strong>[CO_PHONE]</strong>
												<?php _e( 'Email:', 'event_espresso' ); ?>
												<strong><a href="mailto:[CO_EMAIL]" target="_blank">[CO_EMAIL]</a></strong>
											</td>
										</tr>
									</tbody>
								</table>
								&nbsp;
							</td>
						</tr>
					</tbody>
				</table>
			</td>
			<td></td>
		</tr>
	</tbody>
</table>