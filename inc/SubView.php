<?php

/**
 * SubmissionView
 *
 * HTML for edit submission meta box
 */

namespace RichJenks\NFRecon;

?>

<div id="postcustomstuff">
<?php foreach ( $data as $category => $fields ): ?>
	<h2><?= $category; ?></h2>
	<table id="list-table">
		<thead>
			<tr>
				<th class="left">Field</th>
				<th>Value</th>
			</tr>
		</thead>
		<tbody id="the-list">
			<?php foreach ( $fields as $field => $value ): ?>
				<tr>
					<td class="left"><?= htmlentities( $field ); ?></td>
					<td>
						<input type="text" name="" value="<?= htmlentities( $value ); ?>" readonly>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php endforeach; ?>
</div>