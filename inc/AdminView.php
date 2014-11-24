<?php

/**
 * AdminView
 *
 * Options page HTML
 */

// Ensure current tab is valid — either matching tab or first tab
if ( !isset( $_GET['tab'] ) || !array_key_exists( $_GET['tab'], $data ) )
	$_GET['tab'] = key( $data );

?>

<?php // Prevent selection of checkbox label headings ?>
<style>
	th label {
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		-o-user-select: none;
		user-select: none;
	}
</style>

<div class="wrap">

	<h2>Recon</h2>
	<p>When you need to know more about your users, do some recon!</p>
	<p>The first column shows fields that can be added to forms and the second shows the <code>name</code> given to the field.</p>

	<?php // Tabbed categories ?>
	<h2 class="nav-tab-wrapper">
		<?php foreach ($data as $category => $fields): ?>
			<?php $class = ( $category === $_GET['tab'] ) ? ' nav-tab-active' : ''; ?>
			<a href="?page=<?= $this->prefix; ?>options&tab=<?= urlencode( $category ); ?>" class="nav-tab<?= $class; ?>"><?= $category; ?></a>
		<?php endforeach ?>
	</h2>

	<form method="post">

		<?php // Options table ?>
		<table class="form-table">
			<?php foreach ( $data[ $_GET['tab'] ] as $field => $enabled ): ?>
				<tr>
					<th scope="row">
						<label>
							<input type="checkbox" name="<?= 'fields[' . $_GET['tab'] . '][' . $field . ']'; ?>" <?php if ( $enabled ) echo 'checked' ?>>
							<?= $field; ?>
						</label>
					</th>
					<td>
						<input type="text" value="<?= 'recon_' . str_replace( ' ', '_', strtolower( $field ) ); ?>" readonly>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>

		<input type="submit" class="button-primary" name="<?= $this->prefix . 'save'; ?>" value="Save">

	</form>


</div>