Ext.define('Admin.view.AppMenu', 
	{
    extend: 'Ext.panel.Panel',
	alias: 'widget.Admin.view.AppMenu',
	
	plugins: 'responsive',
	
	region: "west",
	width: 250,
	minWidth: 200,
	maxWidth: 350,
	layout: 'accordion',
	collapsible: true,
	frame: true,
	
	split: true,
	bodyPadding: 0,
	scrollable: true,
	itemId: "menuLeft",
	iconCls: "icon_treeSide",
	
	_stateExpand: true,
	
		responsiveConfig: 
		{
			'width > 800': 
			{
			expand: true
			},
		
			'width <= 800': 
			{
			expand: false
			}
		},
		
		setExpand: function(state)
		{				
			if(state == true && this._stateExpand == false)
			{
			this._stateExpand = true;
			this.expand();	
			}
			else if(state == false && this._stateExpand == true)
			{
			this._stateExpand = false;
			var thisObj = this;
			
				this.on("afterlayout",
					function()
					{
						window.setTimeout
						(
							function()
							{
							thisObj.collapse();		
							},
						100);
					},
					null,
					{
					single: true	
					}
				);
			}
		},
		listeners:
		{
			collapse: function()
			{
			this._stateExpand = false;
			},
			expand: function()
			{
			this._stateExpand = true;	
			}
		},
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
							id: k,
							icon: sections[k]["iconSmall"],
							iconBig: sections[k]["iconBig"],
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
		var items = [];
			
			for(var i = 0, y = 0; i < bundles.length; i++)
			{
			var childrens = getChildrens(sections, bundles[i]);
			
				if(childrens.length != 0)
				{				
					items[y] = 	
					{
					xtype: "panel",
					title: bundles[i]["label"],
					iconCls: bundles[i]["iconCls"],
					bundle: bundles[i]["name"],
					scrollable: true,
						items:
						[
							{
							xtype: "treepanel",
							rootVisible: false,
								store: new Ext.data.TreeStore
								(
									{
										root: 
										{
										expanded: true,
										children: childrens	
										}
									}
								)	
							}
						]
					};
				
				y++;
				}
			}
		
		this.items = items;		
		this.callParent();
		}
	}
);