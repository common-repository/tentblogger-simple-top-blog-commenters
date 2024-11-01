<![CDATA[ TentBlogger Simple Top Commenters 2.0 ]]>
<div class="tentblogger-top-commenters-widget-wrapper">
	<fieldset>
		<legend>
			<?php _e('Widget Options', 'tentblogger-top-commenters'); ?>
		</legend>
		
		<!-- title -->
		<label for="<?php echo $this->get_field_id('widget_title'); ?>" class="block">
			<?php _e('Title:', 'tentblogger-top-commenters'); ?>
		</label>
		<input type="text" name="<?php echo $this->get_field_name('widget_title'); ?>" id="<?php echo $this->get_field_id('widget_title'); ?>" value="<?php echo $instance['widget_title']; ?>" class="" />
		<!-- /title -->

		<!-- date range -->
		<label for="<?php echo $this->get_field_id('date_range'); ?>" class="block">
			<?php _e('Date Range:', 'tentblogger-top-commenters'); ?>
		</label>
		<select id="<?php echo $this->get_field_id('date_range'); ?>" name="<?php echo $this->get_field_name('date_range'); ?>">
			<option value="monthly" <?php if ( 'monthly' == $instance['date_range'] ) echo 'selected="selected"'; ?>>
				<?php _e('Monthly', 'tentblogger-top-commenters'); ?>
			</option>
			<option value="weekly" <?php if ( 'weekly' == $instance['date_range'] ) echo 'selected="selected"'; ?>>
				<?php _e('Weekly', 'tentblogger-top-commenters'); ?>
			</option>
			<option value="alltime" <?php if ( 'alltime' == $instance['date_range'] ) echo 'selected="selected"'; ?>>
				<?php _e('All Time', 'tentblogger-top-commenters'); ?>
			</option>
		</select>
		<!-- /date range -->

		<!-- hyperlink -->
		<div class="wrap">
			<input type="checkbox" id="<?php echo $this->get_field_id('hyperlink_commenter'); ?>" name="<?php echo $this->get_field_name('hyperlink_commenter'); ?>" <?php if($instance['hyperlink_commenter'] == 'on') { echo 'checked="checked"'; } ?> />
			<label for="<?php $this->get_field_id('hyperlink_commenter'); ?>">
				<?php _e('Link To Commenter URL?', 'tentblogger-top-commenters'); ?>
			</label>
		</div>
		<!-- /hyperlink -->
		
		<!-- display gravatar -->
		<div class="wrap">
			<input type="checkbox" id="<?php echo $this->get_field_id('display_gravatar'); ?>" name="<?php echo $this->get_field_name('display_gravatar'); ?>" <?php if($instance['display_gravatar'] == 'on') { echo 'checked="checked"'; } ?> />
			<label for="<?php $this->get_field_id('display_gravatar'); ?>">
				<?php _e('Display Gravatar?', 'tentblogger-top-commenters'); ?>
			</label>
		</div>
		<!-- /display gravatar -->
		
		<!-- hide comment count -->
		<div class="wrap">
			<input type="checkbox" id="<?php echo $this->get_field_id('hide_comment_count'); ?>" name="<?php echo $this->get_field_name('hide_comment_count'); ?>" <?php if($instance['hide_comment_count'] == 'on') { echo 'checked="checked"'; } ?> />
			<label for="<?php $this->get_field_id('hide_comment_count'); ?>">
				<?php _e('Hide Total Comments?', 'tentblogger-top-commenters'); ?>
			</label>
		</div>
		<!-- /hide comment count -->
		
	</fieldset>
</div>