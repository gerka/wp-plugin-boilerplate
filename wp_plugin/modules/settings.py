
from wp_plugin import plugin_slug, plugin_classname, slugify
import wp_plugin.modules.plugin_module as m

class settings(m.plugin_module):


	templates = [
		'include/{{plugin_namespace}}/Settings/Settings.php'
	]


	def configure( self, config, target_dir, plugin=False ):
		wp_page_slugs = [
			'general',
			'writing',
			'reading',
			'discussion',
			'media',
			'permalink',
		]
		items = []
		for name, cnf in config.items():
			page_config = {}
			page_config.update(cnf)

			if name in wp_page_slugs:
				standalone = False
			else:
				standalone = True

			page_config.update({
				'module' : {
					'name'			: name,
					'classname'		: plugin_classname(name),
					'slug'			: slugify( name, '-' ),
					'wp_page_slug'	: slugify( name, '_' ),
					'standalone'	: standalone,
				}
			})

			items.append(page_config)

			template_vars = {}
			template_vars.update(plugin._config)
			template_vars.update(page_config)

			self.add_template('include/{{plugin_namespace}}/Settings/Settings{{module.classname}}.php', template_vars )

			if 'css' in page_config:
				self.add_template('src/scss/admin/settings/{{module.slug}}.scss', template_vars )
				plugin.add_template('src/scss/mixins/_mixins.scss')
				plugin.add_template('src/scss/variables/_colors.scss')
				plugin.add_template('src/scss/variables/_dashicons.scss')
				plugin.add_template('src/scss/variables/_variables.scss')

			if 'js' in page_config:
				self.add_template('src/js/admin/settings/{{module.slug}}.js', template_vars )


		super().configure( config, target_dir, plugin )
