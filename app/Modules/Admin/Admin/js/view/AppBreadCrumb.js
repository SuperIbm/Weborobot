Ext.define('Admin.view.AppBreadCrumb', 
	{
    extend: 'Admin.view.ux.BreadCrumb',
	alias: 'widget.Admin.view.AppBreadCrumb',
	
	selectAfterInit: false,
	
		initComponent: function()
		{
		var thisObj = this;

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
							id: k,
							icon: sections[k]["iconSmall"],
							text: sections[k]["text"],
							leaf: true,
							section: k,
							bundle: bundle
							}
						}
					}
				}
				
			return items;	
			}
		
		var sections = Admin.getApplication().Section.get();
		var bundles = Admin.getApplication().Section.getBandles();
		
			var items = 
			{
			id: 'root',
			text: thisObj.index,
			leaf: false,
			iconCls: "icon_home",
				children: 
				[
				]
			};
		
			
			for(var i = 0, y = 0; i < bundles.length; i++)
			{
			var childrens = getChildrens(sections, bundles[i]);
			
				if(childrens.length != 0)
				{
					items.children[y] = 
					{
					id: i,
					bundle: bundles[i],
					bundleName: bundles[i]["name"],
					text: bundles[i]["label"],
					iconCls: bundles[i]["iconCls"],
					leaf: false,
					children: childrens
					};
					
				y++;
				}
			}
			
			this.store = new Ext.data.TreeStore
			(
				{
				root: items
				}
			);
		
		this.callParent();
		}
	}
);