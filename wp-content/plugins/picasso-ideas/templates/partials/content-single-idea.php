<?php
global $picasso_ideas;
$current_user_id = get_current_user_id();
$author_id = get_the_author_meta('ID');
$post_id = $idea_id = get_the_ID();
$edit_link = get_the_permalink($picasso_ideas['idea_edit_page']) . '?id=' . $post_id;

// Campaign
$campaign_id = get_post_meta($post_id, '_idea_campaign', true);

if ($campaign_id) {
	$campaign = get_post($campaign_id);
	$campaign_criteria = get_post_meta($campaign_id, '_campaign_criteria', true);

	// check if votes is enabled for no-status
	$enable_votes_for_no_status = get_post_meta($campaign_id, '_campaign_enable_votes_for_no_status', true);
} else {
	$campaign = array();
	$campaign_criteria = array();
	$enable_votes_for_no_status = '';
}

// review criteria
if ($campaign_criteria) {
	$review_criteria = $campaign_criteria;
} elseif (key_exists('review_criteria', $picasso_ideas) && $picasso_ideas['review_criteria']) {
	$review_criteria = $picasso_ideas['review_criteria'];
} else {
	$review_criteria = array();
}

// expert reviews and average ratings
$expert_reviews_and_average_ratings = pi_get_reviews_and_average_rating($idea_id, 'expert', $review_criteria);
$expert_review_found = $expert_reviews_and_average_ratings['review_found'];

// user reviews and average ratings
$user_reviews_and_average_ratings = pi_get_reviews_and_average_rating($idea_id, 'user', $review_criteria);
$user_review_found = $user_reviews_and_average_ratings['review_found'];

$disable_expert_reviews = get_post_meta($post_id, '_idea_disable_expert_reviews', true);
$disable_user_reviews = get_post_meta($post_id, '_idea_disable_user_reviews', true);
$disable_idea_updates = get_post_meta($post_id, '_idea_disable_idea_updates', true);

// idea updates
$idea_updates = pi_get_idea_updates($post_id);

// idea status
$idea_status = get_post_meta($post_id, '_idea_status', true);

// Render campaign box
pi_render_template(IDEAS_TEMPLATE_PATH . 'partials/campaign-box.php', array('campaign_id' => $campaign_id));
?>

<div class="clear idea-list">
	<div class="col-xs-12 col-sm-2 idea-statistics">
		<div class="row">
			<?php pi_wp_ulike_markup($post_id, $author_id, $idea_status, $enable_votes_for_no_status); ?>

			<?php
			$args = array(
				// 'author__in' => array($current_user_id),
				'post_id'    => $post_id,
			);
			$comments = get_comments($args);
			?>
			<div class="idea-comment-count">
				<a href="#idea-comments" class="idea-comment-popup-link<?php echo (count($comments)) ? ' comment-found' : ''; ?>" data-post-id="<?php echo $post_id; ?>" data-toggle="idea-tooltip" data-placement="top" title="<?php _e('Comment this idea!', 'picasso-ideas'); ?>">
					<span class="count-comments"><?php echo count($comments); ?></span>
					<span class="fa fa-comments"></span>
				</a>
			</div>

			<?php echo pi_get_idea_status($idea_status); ?>

			<div class="views-and-favorite">
				<?php
				$views = get_post_meta($post_id, '_views_count', true);
				$favorites = get_post_meta($post_id, '_idea_favorites', false);
				?>
				<span class="views-count"><?php echo $views ? $views : 0; ?> <?php _e('views', 'picasso-ideas'); ?></span>
				<a href="javascript:void(0)" class="put-in-favorite" data-toggle="idea-tooltip" data-placement="top" title="<?php _e('Put in favorites', 'picasso-ideas'); ?>" data-post-id="<?php echo $post_id; ?>">
					<span class="favorite-star fa <?php echo ($favorites && in_array($current_user_id, $favorites)) ? 'fa-star' : 'fa-star-o'; ?>"></span>
					<span class="favorites-count"><?php echo count($favorites); ?></span>
				</a>
			</div>
		</div>
	</div>

	<div class="col-xs-12 col-sm-10">
		<div class="row">
			<div class="idea-post-title">
				<div class="table">
					<div class="table-cell"><?php echo get_avatar($author_id, 32); ?></div>

					<div class="table-cell">
						<!-- review-stats -->
						<div class="review-stats">
							<?php // expert review chart ?>
							<?php if ($expert_review_found): ?>
							<?php
							$expert_average_ratings = $expert_reviews_and_average_ratings['average'];
							$string = sprintf(_n('%d expert review', '%d expert reviews', count($expert_reviews_and_average_ratings['reviews']), 'picasso-ideas'), count($expert_reviews_and_average_ratings['reviews']));
							?>
							<span class="picasso-idea-init-chart expert-reviews-stats" <?php echo pi_get_data_for_chart($idea_id, 'expert', $review_criteria); ?>>
								<span class="average"><?php echo $expert_average_ratings; ?></span>
								<span class="fa fa-bar-chart"></span>
								<?php echo '(' . $string . ')'; ?>
							</span>
							<?php endif ?>

							<?php // user review chart ?>
							<?php if ($user_review_found): ?>
							<?php
							$user_average_ratings = $user_reviews_and_average_ratings['average'];
							$string = sprintf(_n('%d user review', '%d user reviews', count($user_reviews_and_average_ratings['reviews']), 'picasso-ideas'), count($user_reviews_and_average_ratings['reviews']));
							?>
							<span class="picasso-idea-init-chart user-reviews-stats" <?php echo pi_get_data_for_chart($idea_id, 'user', $review_criteria); ?>>
								<span class="average"><?php echo $user_average_ratings; ?></span>
								<span class="fa fa-bar-chart"></span>
								<?php echo '(' . $string . ')'; ?>
							</span>
							<?php endif ?>
						</div><!-- .review-stats -->
					</div><!-- .table-cell -->
				</div><!-- .table -->
			</div><!-- .idea-post-title -->

			<div class="idea-post-content">
				<?php
				$read_more = '<a href="#idea-details" class="go-to-idea-detials"> [' . __('See More', 'picasso-ideas') . ']</a>';
				echo wp_trim_words(get_the_content(), 25, ' ' . $read_more);
				?>
			</div>

			<div class="idea-post-footer">
				<ul>
					<?php if (function_exists('bp_core_get_user_domain')): ?>
						<li class="idea-author">
							<a href="<?php echo bp_core_get_user_domain($author_id); ?>"><?php echo bp_core_get_user_displayname($author_id); ?></a>
						</li>
					<?php endif ?>

					<li class="idea-posted">
						<?php
						$posted_on_timestamp = get_post_time();
						$updated_on_timestamp = get_post_modified_time();
						$posted = sprintf(_x('%s ago', '%s = human-readable time difference', 'picasso-ideas'), human_time_diff($posted_on_timestamp, current_time('timestamp')));
						$updated = sprintf(_x('%s ago', '%s = human-readable time difference', 'picasso-ideas'), human_time_diff($updated_on_timestamp, current_time('timestamp')));
						?>
						<span class="fa fa-clock-o"></span>
						<?php
						if ($posted_on_timestamp === $updated_on_timestamp) {
							echo __('Posted', 'picasso-ideas') . ': ' . $posted;
						} else {
							echo __('Posted', 'picasso-ideas') . ': ' . $posted;
							echo ' | ';
							echo __('Updated', 'picasso-ideas') . ': ' . $updated;
						}
						?>
					</li>

					<?php if (pi_is_author_post($author_id)): ?>
						<li class="edit-idea">
							<span class="fa fa-edit"></span>
							<a href="<?php echo $edit_link; ?>"><?php _e('Edit', 'picasso-ideas'); ?></a>
						</li>
					<?php endif ?>
				</ul>

				<?php // Todo: show tags ?>
			</div>

			<?php // Todo: check posts socail share ?>
			<?php get_template_part('page-parts/posts-social-share'); ?>
		</div>
	</div>
</div>

<?php
// find idea experts
$idea_experts = pi_get_experts_for_given_idea($post_id);

// assign expert template
if (isset($_GET['add-experts']) && pi_ideas_modifier() && $disable_expert_reviews !== 'on' && $idea_status == 'review') {
    $params = array(
        'idea_id'      => $post_id,
        'idea_experts' => $idea_experts,
        'campaign_id'  => $campaign_id,
    );

    pi_render_template(IDEAS_TEMPLATE_PATH . 'partials/idea-add-experts.php', $params);
}

// idea tabs template
elseif (empty($_GET)) {
    $params = array(
		'expert_reviews_and_average_ratings' => $expert_reviews_and_average_ratings,
		'user_reviews_and_average_ratings'   => $user_reviews_and_average_ratings,
		'idea_updates'                       => $idea_updates,
		'idea_id'                            => $post_id,
		'campaign_id'                        => $campaign_id,
		'idea_status'                        => $idea_status,
		'idea_experts'                       => $idea_experts,
		'current_user_id'                    => $current_user_id,
		'review_criteria'                    => $review_criteria,
		'disable_expert_reviews'             => $disable_expert_reviews,
		'disable_user_reviews'               => $disable_user_reviews,
		'disable_idea_updates'               => $disable_idea_updates,
    );

    pi_render_template(IDEAS_TEMPLATE_PATH . 'partials/idea-tabs.php', $params);
}
?>

<?php
// Post navigation
if (sq_option('post_navigation', 1) == 1) {
	kleo_post_nav();
}
