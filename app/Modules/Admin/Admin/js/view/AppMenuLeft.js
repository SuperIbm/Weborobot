Ext.define('Admin.view.AppMenuLeft', 
	{
    extend: 'Ext.toolbar.Toolbar',
	alias: 'widget.Admin.view.AppMenuLeft',
	
	plugins: 'responsive',
	
	region: "west",
	width: 70,
	split: true,
	cls: "menuLeft",
	dock: 'left',
	
		responsiveConfig: 
		{
			'width > 800': 
			{
			visible: true
			},
		
			'width <= 800': 
			{
			visible: false
			}
		},
	
		initComponent: function()
		{
		var pathImage = Admin.getApplication().Access.getUserImage() == false ? 'app/Modules/Admin/Admin/images/imageUserEmpty.jpg' : Admin.getApplication().Access.getUserImage()["path"];
		
			this.items = 
			[
				{
				text: Admin.getApplication().Access.getUser("login"),
				icon: pathImage,
				baseCls: "image",
				width: 60,
				height: 75,
				action: "userPicture",
				iconAlign: 'top',
				margin: "0 0 17 0"
				}
			];
			
		var sections = Admin.getApplication().Section.get();
		var bundles = Admin.getApplication().Section.getBandles();
		
			for(var i = 0; i < bundles.length; i++)
			{
				for(k in sections)
				{
					if(bundles[i]["label"] == sections[k]["bundle"] && sections[k]["menuLeft"] == true && Admin.getApplication().Access.is(k, "isRead") == true)
					{
						this.items[this.items.length] = 
						{
						text: sections[k]["text"],
						icon: sections[k]["iconBig"],
						iconAlign: 'top',
						width: 60,
						height: 70,
						baseCls: "button",
						overCls: "overCls",
						margin: "0 0 3 0",
						action: k,
						bundle: sections[k]["bundle"]
						};
					}
				}
			}
			
		this.items[this.items.length] = "->";
			
			this.items[this.items.length] = 
			{
			text: this.exit,
			tooltip: this.exit,
			iconCls: "icon_big_exit",
			iconAlign: 'top',
			width: 60,
			height: 50,
			baseCls: "button",
			overCls: "overCls",
			action: "exit"	
			}
							
		this.callParent();
		}
	}
);