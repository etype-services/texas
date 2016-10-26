<?php
/**
 * @file
 * Default view template to display a list of items in a field split.
 *
 * Available template variables:
 * - $rows: The rows to render.
 *
 */
?>
<div class="rows-inner">
	<?php foreach ($rows as $id => $item): ?>
		<div class="row"><?php print $item; ?></div>
	<?php endforeach; ?>
</div>