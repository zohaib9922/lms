<?php

/**
 * Don't change it, it's supporting modal in other place
 * if get_the_ID() empty, then it's means we are passing $post variable from another place
 */
if (get_the_ID())
    global $post;

$video          = maybe_unserialize(get_post_meta($post->ID, '_video', true));
$videoSource    = tutor_utils()->avalue_dot('source', $video, 'html5');
$runtimeHours   = tutor_utils()->avalue_dot('runtime.hours', $video);
$runtimeMinutes = tutor_utils()->avalue_dot('runtime.minutes', $video);
$runtimeSeconds = tutor_utils()->avalue_dot('runtime.seconds', $video);
$sourceVideoID  = tutor_utils()->avalue_dot('source_video_id', $video);
$poster         = tutor_utils()->avalue_dot('poster', $video);
$videoAttachment = $sourceVideoID ? tutor_utils()->get_attachment_data($sourceVideoID) : null;

$video_sources  = tutor_utils()->get_video_sources(false);

$supported_sources = tutor_utils()->get_option('supported_video_sources', array());
!is_array($supported_sources) ? $supported_sources = array($supported_sources) : 0;
$GLOBALS['supported_sources'] = $supported_sources;

if (!is_array($supported_sources) || !count($supported_sources)) {
    $notice = __('No video source selected from settings!', 'tutor');
    echo "<div class='tutor-alert tutor-warning'>
        <div class='tutor-alert-text'>
            <span class='tutor-alert-icon tutor-fs-4 tutor-icon-circle-info tutor-mr-12'></span>
            <span>{$notice}</span>
        </div>
    </div>";
    // _e('No video source selected from settings!', 'tutor');
    return;
}


function tutor_video_input_state($videoSource, $source){
    $value = ($videoSource == $source && in_array($source, $GLOBALS['supported_sources'])) ? 'block' : 'none';
    echo 'display:'.$value.';';
}
?>

<div class="tutor-mb-32">
    <label class="tutor-form-label">
        <?php
        if ($post->post_type === tutor()->course_post_type) {
            _e('Course Intro Video', 'tutor');
        } else {
            _e('Video Source', 'tutor');
        }
        ?>
    </label>
    
    <div class="tutor-input-group tutor-mb-16 tutor-mt-12 tutor-d-block">
        <div class="tutor-video-upload-wrap">
            <div class="tutor-dropdown-icon-pack tutor-mt-4" data-video_source="<?php echo empty($videoSource) ? '' : $videoSource; ?>">
                <i class="tutor-icon-brand-html5-bold" data-for="html5"></i>
                <i class="tutor-icon-brand-youtube-line" data-for="youtube"></i>
                <i class="tutor-icon-brand-vimeo-line" data-for="vimeo"></i>
                <i class="tutor-icon-shortcode" data-for="shortcode"></i>
                <i class="tutor-icon-link" data-for="external_url"></i>
                <i class="tutor-icon-coding" data-for="embedded"></i>
            </div>
            <select name="video[source]" class="tutor-form-control tutor-select-icon-primary tutor_lesson_video_source no-tutor-dropdown">
                <option value="-1"><?php _e('Select Video Source', 'tutor'); ?></option>
                <?php
                foreach ($video_sources as $value => $source) {
                    if (in_array($value, $supported_sources)) {
                        echo '<option value="' . $value . '" ' . selected($value, $videoSource) . '  data-icon="' . $source['icon'] . '">
                                    ' . $source['title'] . '
                                </option>';
                    }
                }
                ?>
            </select>

            <div class="tutor-mt-16 video-metabox-source-item video_source_wrap_html5 tutor-dashed-uploader <?php echo $sourceVideoID ? 'tutor-has-video' : ''; ?>" style="<?php tutor_video_input_state($videoSource, 'html5'); ?>">
                <div class="video-metabox-source-html5-upload">
                    <p class="video-upload-icon"><i class="tutor-icon-upload-icon-line"></i></p>
                    <p><strong><?php _e('Drag & Drop Your Video', 'tutor'); ?></strong></p>
                    <p><?php _e('File Format: ', 'tutor'); ?> <span class="tutor-color-black">.mp4</span></p>
                    <p class="tutor-color-black"><?php _e('or', 'tutor'); ?></p>

                    <div class="video_source_upload_wrap_html5">
                        <button class="video_upload_btn tutor-btn tutor-btn-secondary tutor-btn-md">
                            <?php _e('Browse File', 'tutor'); ?>
                        </button>
                        <input type="hidden" class="input_source_video_id" name="video[source_video_id]" value="<?php echo $sourceVideoID; ?>">
                    </div>
                </div>

                <div class="html5-video-data">
                    <?php
                    // Load Attachment card segment
                    tutor_load_template_from_custom_path(tutor()->path . '/views/fragments/attachments.php', array(
                        'attachments' => array($videoAttachment ? $videoAttachment : (object)array('id' => 0, 'url' => '', 'title' => '', 'size' => '')),
                        'size_below' => true,
                        'no_control' => true
                    ), false);

                    echo '<div class="tutor-fs-6 tutor-fw-medium tutor-color-secondary tutor-mb-12" >' . __('Upload Video Poster', 'tutor') . '</div>';
                    // Load thumbnail segment
                    tutor_load_template_from_custom_path(tutor()->path . '/views/fragments/thumbnail-uploader.php', array(
                        'media_id' => tutor_utils()->avalue_dot('poster', $video),
                        'input_name' => 'video[poster]'
                    ), false);
                    ?>
                </div>
            </div>

            <div class="tutor-mt-16 video-metabox-source-item video_source_wrap_external_url tutor-dashed-uploader" style="<?php tutor_video_input_state($videoSource, 'external_url'); ?>">
                <input class="tutor-form-control" type="text" name="video[source_external_url]" value="<?php echo tutor_utils()->avalue_dot('source_external_url', $video); ?>" placeholder="<?php _e('Paste External Video URL', 'tutor'); ?>">
            </div>

            <div class="tutor-mt-16 video-metabox-source-item video_source_wrap_shortcode tutor-dashed-uploader" style="<?php tutor_video_input_state($videoSource, 'shortcode'); ?>">
                <input class="tutor-form-control" type="text" name="video[source_shortcode]" value="<?php echo tutor_utils()->avalue_dot('source_shortcode', $video); ?>" placeholder="<?php _e('Paste Shortcode', 'tutor'); ?>">
            </div>

            <div class="tutor-mt-16 video-metabox-source-item video_source_wrap_youtube tutor-dashed-uploader" style="<?php tutor_video_input_state($videoSource, 'youtube'); ?>">
                <input class="tutor-form-control" type="text" name="video[source_youtube]" value="<?php echo tutor_utils()->avalue_dot('source_youtube', $video); ?>" placeholder="<?php _e('Paste YouTube Video URL', 'tutor'); ?>" data-youtube_api_key="<?php echo tutor_utils()->get_option('lesson_video_duration_youtube_api_key', ''); ?>">
            </div>

            <div class="tutor-mt-16 video-metabox-source-item video_source_wrap_vimeo tutor-dashed-uploader" style="<?php tutor_video_input_state($videoSource, 'vimeo'); ?>">
                <input class="tutor-form-control" type="text" name="video[source_vimeo]" value="<?php echo tutor_utils()->avalue_dot('source_vimeo', $video); ?>" placeholder="<?php _e('Paste Vimeo Video URL', 'tutor'); ?>">
            </div>

            <div class="tutor-mt-16 video-metabox-source-item video_source_wrap_embedded tutor-dashed-uploader" style="<?php tutor_video_input_state($videoSource, 'embedded'); ?>">
                <textarea class="tutor-form-control" name="video[source_embedded]" placeholder="<?php _e('Place your embedded code here', 'tutor'); ?>"><?php echo tutor_utils()->avalue_dot('source_embedded', $video); ?></textarea>
            </div>
        </div>
    </div>
</div>

<!-- For Lesson -->
<?php if ($post->post_type !== tutor()->course_post_type) : ?>
    <div class="tutor-mb-20">
        <label class="tutor-form-label"><?php _e('Video playback time', 'tutor'); ?></label>
        <div class="tutor-input-group tutor-option-field-video-duration">
            <div class="tutor-row">
                <div class="tutor-col-4">
                    <input class="tutor-form-control" type="number" value="<?php echo $runtimeHours ? $runtimeHours : '00'; ?>" name="video[runtime][hours]" min="0">
                    <span><?php _e('Hour', 'tutor'); ?></span>
                </div>
                <div class="tutor-col-4">
                    <input class="tutor-form-control" type="number" class="tutor-number-validation" data-min="0" data-max="59" value="<?php echo $runtimeMinutes ? $runtimeMinutes : '00'; ?>" name="video[runtime][minutes]" min="0">
                    <span><?php _e('Minute', 'tutor'); ?></span>
                </div>
                <div class="tutor-col-4">
                    <input class="tutor-form-control" type="number" class="tutor-number-validation" data-min="0" data-max="59" value="<?php echo $runtimeSeconds ? $runtimeSeconds : '00'; ?>" name="video[runtime][seconds]" min="0">
                    <span><?php _e('Second', 'tutor'); ?></span>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
