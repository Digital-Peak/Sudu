<?php
/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */
?>
<div class="dp-icons">
	<?php echo str_replace('<svg', '<svg id="dp-icon-closefull"', file_get_contents(config('view.icons_folder') . '/actions/compress.svg')); ?>
	<?php echo str_replace('<svg', '<svg id="dp-icon-full"', file_get_contents(config('view.icons_folder') . '/actions/expand.svg')); ?>
</div>
