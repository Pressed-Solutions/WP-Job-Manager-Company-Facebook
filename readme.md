# Introduction
This plugin adds a Facebook URL field to the Job Data section when creating a new job using [WP Job Manager](https://wpjobmanager.com).

# Requirements
- [WP Job Manager](http://wpjobmanager.com/) plugin

# Installation
- Install and activate this plugin
- Do *one* of the following to show the Facebook field on your site’s frontend:
	- Copy the `templates/content-single-job_listing-company.php` file to `your-theme-folder/job_manager/` folder (create the `job_manager` folder if not present); or
	- Add `<?php the_company_facebook(); ?>` to any of the WP Job Manager templates to display the field in that location.
