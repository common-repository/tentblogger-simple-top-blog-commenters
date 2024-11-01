<?php if(strlen(trim($widget_title)) > 0) { ?>
	<h3 class="widget-title">
		<?php echo $widget_title; ?>
	</h3>
<?php
	} // end if
		
		global $wpdb;
		$i = 0;
		
		if($hide_comment_count == 'on') { 
			$comment_list = '<ol>';
		} else {
			$comment_list = '<ul>';
		} // end if
		
		foreach($commenters as $commenter) {

			// get the author's URL
			$url = $wpdb->get_var("
				select comment_author_url from $wpdb->comments
				where comment_author_email = '" . addslashes($commenter->comment_author_email) . "'
				and comment_approved = 1
				order by comment_date desc limit 1
			");
			
				$comment_list .= '<li>';
				
					// if there's a url, begin the anchor
					if($hyperlink_commenter == 'on' && strlen(trim($url)) > 0) {
						$comment_list .= "<a href='" . $url . "' rel='nofollow' target='_blank'>";
					} // end if
					
						// display the user's gravatar
						if($display_gravatar == 'on') {
							$gravatar_url = urlencode(md5(strtolower($commenter->comment_author_email)));
							$comment_list .= '<img class="tcwGravatar" src="http://www.gravatar.com/avatar/' . $gravatar_url . '?s=16" alt="' . $commenter->comment_author . '" />';
						} // end if
						
						// actually print the commenter's name
						$comment_list .= $commenter->comment_author;
							
						// displays the number of comments made by the user
						if($hide_comment_count != 'on') {
							$comment_list .= ' (' . $commenter->comment_comments . ')';
						}
					
					// if the user wnats to hyperlink the user, close the anchor
					if($hyperlink_commenter == 'on' && strlen(trim($url)) > 0) {
						$comment_list .= "</a>";
					} // end if

				$comment_list .= '</li>';
			
			// if we're at 10, get out.
			if(++$i == 10) {
				break;
			} // end if
			
		} // end foreach
		
		if($hide_comment_count == 'on') { 
			$comment_list .= '</ol>';
		} else {
			$comment_list .= '</ul>';
		} // end if
		
		echo $comment_list;
?>