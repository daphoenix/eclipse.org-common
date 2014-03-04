<?php
/*******************************************************************************
 * Copyright (c) 2014 Eclipse Foundation and others.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.eclipse.org/legal/epl-v10.html
 *
 * Contributors:
 *    Denis Roy (Eclipse Foundation)- initial API and implementation
 *    gbarbier mia-software com - bug 284239
 *    Christopher Guindon (Eclipse Foundation) - Initial implementation of solstice
 *******************************************************************************/
?>
<!-- nav -->
<aside id="aside-left-nav" class="col-md-4">
  <ul class="ul-left-nav nav">
	  <?php foreach ($variables['menu']['nav']['#items'] as $link) :?>

			<?php if ($link->getURL() == "") :?>
				<?php if ($link->getTarget() == "__SEPARATOR") : ?>
				  <li class="separator">
				    <a class="separator">
						  <?php print $link->getText() ?><?php print $variables['menu']['nav']['img_separator'];?>
						</a>
					</li>
				<?php else: ?>
					<li>
					  <a class="nolink" href="#"><?php print $link->getText() ?></a>
					</li>
				<?php endif; ?>
			<?php elseif (stripos($link->getURL(), 'project_summary.php') !== FALSE) :?>
			  <li class="about">
			    <a href="<?php print $link->getURL() ?>"><?=$link->getText();?></a>
				</li>
			<?php else: // if $link->getURL() is not empty. ?>

			  <?php if($link->getTarget() == "__SEPARATOR") :?>
				  <li class="separator">
				    <a class="separator" href="<?php print $link->getURL() ?>">
					    <?php print $link->getText() ?>
						    <?php print $variables['menu']['nav']['img_separator'];?>
						</a>
					</li>
			  <?php else:?>
				  <li>
				    <a href="<?php print $link->getURL() ?>" target="<?php print ($link->getTarget() == "_blank") ? "_blank" : "_self" ?>">
					    <?php print $link->getText() ?>
					  </a>
			    </li>
				<?php endif;?>

			<?php endif;?>
		<?php endforeach; ?>
	</ul>
  <?php print $Nav->getHTMLBlock(); ?>
</aside>
