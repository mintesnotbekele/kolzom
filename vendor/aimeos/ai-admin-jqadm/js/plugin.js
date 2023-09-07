/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2017-2023
 */



Aimeos.Plugin = {

	init() {
		Aimeos.components['plugin'] = new Vue({
			el: document.querySelector('.item-plugin #basic'),
			data: {
				item: null,
				cache: {},
				decorators: [],
				providers: [],
				siteid: null,
			},
			beforeMount() {
				this.Aimeos = Aimeos;
				this.decorators = JSON.parse(this.$el.dataset.decorators || '[]');
				this.providers = JSON.parse(this.$el.dataset.providers || '[]');
				this.item = JSON.parse(this.$el.dataset.item || '{}');
				this.siteid = this.$el.dataset.siteid;
			},
			mixins: [this.mixins]
		});
	},


	mixins: {
		methods: {
			can(action) {
				if(this.item['plugin.siteid']) {
					let allow = (new String(this.item['plugin.siteid'])).startsWith(this.siteid);

					switch(action) {
						case 'change': return allow;
					}
				}

				return false;
			},


			config(provider, type) {
				if(!provider) return []
				if(this.cache[provider]) return this.cache[provider]

				provider = String(provider).replace(/"/g, '\\"')
				type = String(type).replace(/"/g, '\\"')

				return this.cache[provider] = Aimeos.query(`query {
					getPluginConfig(provider: "` + provider + `", type: "` + type + `") {
						code
						label
						type
					}
				}`).then(result => {
					return (result?.getPluginConfig || []).map(entry => {
						entry.key = entry.code
						return entry
					})
				})
			},


			decorate(name) {
				if(!(new String(this.item['plugin.provider'])).includes(name)) {
					this.item['plugin.provider'] = this.item['plugin.provider'] + ',' + name
				}
			},
		}
	}
};



$(function() {

	Aimeos.Plugin.init();
});
