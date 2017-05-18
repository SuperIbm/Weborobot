Ext.define('Admin.view.AppHeader', 
	{
    extend: 'Ext.toolbar.Toolbar',
	alias: 'widget.Admin.view.AppHeader',
	
	region: "north",
	
	split: false,
	bodyPadding: 0,
	cls: "header",
	
		initComponent: function()
		{
			function getChildrens(sections, bundle)
			{
			var items = [];
			
				for(var k in sections)
				{				
					if(sections[k]["bundle"] == bundle["label"])
					{							
						if(Admin.getApplication().Access.is(k, "isRead") == true)
						{
							items[items.length] = 
							{
							index: k,
							section: k,
							icon: sections[k]["iconSmall"],
							iconBig: sections[k]["iconBig"],
							text: sections[k]["text"],
							bundle: bundle
							}
						}
					}
				}
				
				if(items.length) return items;	
				else return null;
			}
		
		var sections = Admin.getApplication().Section.get();
		var bundles = Admin.getApplication().Section.getBandles();
		var items = [];
			
			for(var i = 0, y = 0; i < bundles.length; i++)
			{
			var childrens = getChildrens(sections, bundles[i]);
			
				if(childrens)
				{
					items[y] = 
					{
					index: i,
					bundle: bundles[i],
					bundleName: bundles[i]["name"],
					text: bundles[i]["label"],
					iconCls: bundles[i]["iconCls"],
					menu: childrens
					};
					
				y++;
				}
			}

		var locale = Admin.getApplication().Access.getLocale().get();
		var locals = Admin.getApplication().Access.getLocale().getLolals();
		var itemsLocale = [];
		var i = 0;

			for(var k in locals)
			{
				itemsLocale[i] =
				{
				text: locals[k].label,
				icon: locals[k].icon,
				index: k
				};

			i++;
			}

			this.items = 
			[
				{
				xtype: 'tbtext',
				text: 'Weborobot',
				cls: "nameCms"
				},
				"->",
				{
				xtype: "button",
				text: this.items[2].text,
				iconCls: "icon_home",
				padding: "4 7 4 7",
				action: "home"
				},
				{
				xtype: "button",
				text: this.items[3].text,
				iconCls: "icon_menu",
				padding: "4 2 4 7",
				action: "menu",
					menu: new Ext.menu.Menu
					(
						{
						items: items	
						}
					)
				},
				{
				xtype: "button",
				text: this.items[4].text,
				iconCls: "icon_destroy_cache",
				padding: "4 7 4 7",
				action: "destroy_cache"
				}/*,
				{
				xtype: "button",
				text: Admin.getApplication().Access.getLocale().getParams(locale)["label"],
				icon: Admin.getApplication().Access.getLocale().getParams(locale)["icon"],
				padding: "4 2 4 7",
				action: "locale",
					menu: new Ext.menu.Menu
					(
						{
						items: itemsLocale
						}
					)
				}*/,
				{
				xtype: "button",
				text: this.items[5].text,
				iconCls: "icon_out",
				padding: "4 7 4 7",
				action: "exit"
				}
			];
			
		this.callParent();
		}
	}
);