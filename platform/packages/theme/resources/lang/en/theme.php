<?php

return [
    'name' => 'Themes',
    'theme' => 'Theme',
    'author' => 'Author',
    'version' => 'Version',
    'active_success' => 'Activate theme :name successfully!',
    'active' => 'Active',
    'activated' => 'Activated',
    'appearance' => 'Appearance',
    'theme_options' => 'Theme Options',
    'save_changes' => 'Save Changes',
    'custom_css' => 'Custom CSS',
    'custom_js' => 'Custom JS',
    'custom_header_js' => 'Header JS',
    'custom_header_js_placeholder' => 'JS in header of page, wrap it inside &#x3C;script&#x3E;&#x3C;/script&#x3E;',
    'custom_body_js' => 'Body JS',
    'custom_body_js_placeholder' => 'JS in body of page, wrap it inside &#x3C;script&#x3E;&#x3C;/script&#x3E;',
    'custom_footer_js' => 'Footer JS',
    'custom_footer_js_placeholder' => 'JS in footer of page, wrap it inside &#x3C;script&#x3E;&#x3C;/script&#x3E;',
    'custom_html' => 'Custom HTML',
    'custom_header_html' => 'Header HTML',
    'custom_header_html_placeholder' => 'HTML in header of page, no special tags: script, style, iframe...',
    'custom_body_html' => 'Body HTML',
    'custom_body_html_placeholder' => 'HTML in body of page, no special tags: script, style, iframe...',
    'custom_footer_html' => 'Footer HTML',
    'custom_footer_html_placeholder' => 'HTML in footer of page, no special tags: script, style, iframe...',
    'remove_theme_success' => 'Remove theme successfully!',
    'theme_is_not_existed' => 'This theme is not existed!',
    'remove' => 'Remove',
    'remove_theme' => 'Remove theme',
    'remove_theme_confirm_message' => 'Do you really want to remove this theme?',
    'remove_theme_confirm_yes' => 'Yes, remove it!',
    'total_themes' => 'Total themes',
    'add_new' => 'Add new',
    'theme_activated_already' => 'Theme ":name" is activated already!',
    'theme_inherit_not_found' => 'The inherit theme ":name" is not found!',
    'missing_json_file' => 'Missing file theme.json!',
    'theme_invalid' => 'Theme is valid!',
    'published_assets_success' => 'Publish assets for :themes successfully!',
    'cannot_remove_theme' => 'Cannot remove activated theme, please activate another theme before removing ":name"!',
    'cannot_remove_inherit_theme' => 'Cannot remove theme ":name" because it is inherited by current theme!',
    'theme_deleted' => 'Theme ":name" has been destroyed.',
    'removed_assets' => 'Remove assets of a theme :name successfully!',
    'go_to_dashboard' => 'Go to dashboard',
    'theme_option_general' => 'General',
    'theme_option_general_description' => 'General settings',
    'theme_option_seo_open_graph_image' => 'SEO default Open Graph image',
    'theme_option_seo_open_graph_image_helper' => 'Default Open Graph image when sharing on social networks. If not set, it will get from theme options logo in Admin -> Appearance -> Theme Options -> Logo. That image type must be PNG, JPG or GIF, do not use modern image type such as WebP or Avif. The image dimensions must be at least 200x200 pixels.',
    'theme_option_seo_index' => 'SEO Index',
    'theme_option_seo_index_helper' => 'When "No Index" is selected, search engines are blocked from indexing the site, preventing it from appearing in search engine results.',
    'seo_index_options' => [
        'index' => 'Index',
        'no_index' => 'No Index',
    ],
    'theme_option_logo' => 'Logo',
    'theme_option_favicon' => 'Favicon',
    'theme_option_favicon_type' => 'Favicon Type',
    'theme_option_breadcrumb' => 'Breadcrumb',
    'folder_is_not_writeable' => 'Cannot write files! Folder :name is not writable. Please chmod to make it writable!',
    'breadcrumb_enabled' => 'Enable breadcrumb?',
    'themes' => 'Themes',
    'child_of' => 'Child of ":theme"',
    'typography' => 'Typography',
    'robots_txt_editor' => 'Robots.txt Editor',
    'robots_txt_content' => 'Robots.txt Content',
    'robots_txt_not_writable' => 'Cannot write robots.txt file! Please chmod to make it writable! (Your robots.txt file is located at :path)',
    'robots_txt_content_helper' => 'After saved, you can check your robots.txt here: :link',
    'robots_txt_file' => 'Upload robots.txt file',
    'robots_txt_file_helper' => 'If you want to upload a robots.txt file, please select it here.',
    'email_template_logo_helper_text' => 'If don\'t set, it will get from theme options logo in Admin -> Appearance -> Theme Options -> Logo.',
    'settings' => [
        'website_tracking' => [
            'title' => 'Website Tracking',
            'description' => 'Configure website tracking',
            'google_tag_id' => 'Google tag ID',
            'google_tag_id_placeholder' => 'Example: G-123ABC4567',
            'google_tag_code' => 'Google tag code',
        ],
    ],
    'term_and_privacy_policy_url' => 'Terms and Privacy Policy URL',
    'site_title_separator' => 'SEO title separator',
    'no_meta_keywords' => "Meta keywords was removed by Google, you don't need to add meta keywords to your website. Learn more: :link",
];
