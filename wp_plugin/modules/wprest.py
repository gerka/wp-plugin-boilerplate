from wp_plugin import plugin_slug, plugin_classname, slugify
import wp_plugin.modules.plugin_module as m

class wprest(m.plugin_module):

	def pre_process(self):
		super().pre_process()
		self.plugin.add_template('include/{{plugin_namespace}}/WPRest/WPRest.php' )

	def config( self, config, target_dir, plugin=False ):

		items = []
		for name, cnf in config.items():
			wprest_config = {}
			wprest_config.update(cnf)
			wprest_config.update({
				'module' : {
					'name'			: name,
					'classname'		: plugin_classname(name),
					'slug'			: slugify( name, '-' ),
				}
			})

			items.append(wprest_config)

			template_vars = {}
			template_vars.update(wprest_config)
			template_vars.update(plugin._config)

			self.add_template('include/{{plugin_namespace}}/WPRest/WPRest{{module.classname}}.php', template_vars, False )

		super().config( config, target_dir, plugin )

		self.template_vars = {'items' : items}
