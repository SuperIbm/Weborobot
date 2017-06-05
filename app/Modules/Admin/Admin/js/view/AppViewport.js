Ext.define('Admin.view.AppViewport', 
	{
    extend: 'Ext.container.Viewport',
	alias: 'widget.Admin.view.AppViewport',
		
		requires:
		[
		"Admin.view.AppMenuLeft",
		"Admin.view.AppMenu",
		"Admin.view.AppDesctop",
		"Admin.view.AppHeader",
		"Admin.view.AppFooter"
		], 
	
	bodyBorder: false,
	layout: "border",
	frame: true,
	padding: "0, 10, 5, 10",
	cls: "wallpaper_2",
	
	minWidth: 450,
	minHeight: 450,
		
	
		destroy: function()
		{
		Admin.getApplication().App._setMenuLeft(null);
		Admin.getApplication().App._setMenu(null);
		Admin.getApplication().App._setDesctop(null);
		Admin.getApplication().App._setHeader(null);
		Admin.getApplication().App._setFooter(null);
		Admin.getApplication().App._setContent(null);
		Admin.getApplication().App._setBreadCrumb(null);
		
		Admin.getApplication().Section.delete();
		Admin.getApplication().Section.delete();
		Admin.getApplication().Widget.delete();
		Admin.getApplication().Component.delete();
		
		Admin.getApplication().Access._setConfig();
		
		Admin.getApplication().App.isReady(false);
		
		Ext.util.History.add("", false);	
		
		this.callParent();
		},	
		initComponent: function()
		{			
		var adminSections = Admin.getApplication().Access.getSections();
		
			for(var k in adminSections)
			{			
				Admin.getApplication().Section.set
				(
				k, 
				adminSections[k]["labelSection"], 
				adminSections[k]["bundle"], 
				adminSections[k]["iconSmall"], 
				adminSections[k]["iconBig"], 
				adminSections[k]["menuLeft"] == "Да" ? true : false, 
				adminSections[k]["pathToJs"], 
				adminSections[k]["pathToCss"]
				);
			}
			
		var modules = Admin.getApplication().Access.getModules(), values;
		
			for(var module in modules)
			{			
				if(modules[module]["components"])
				{				
					for(var component in modules[module]["components"])
					{
						if(module && component)
						{
						values = modules[module]["components"][component];
						
							Admin.getApplication().Component.set
							(
                            module,
                            component,
                            values["controller"],
                            values["labelComponent"],
                            values["pathToJs"],
                            values["pathToCss"]
							);
						}
					}
				}

                if(modules[module]["widgets"])
                {
                    for(var widget in modules[module]["widgets"])
                    {
                        if(module && widget)
                        {
                        values = modules[module]["widgets"][widget];

                            Admin.getApplication().Widget.set
                            (
                            module,
                            widget,
                            values["labelWidget"],
                            values["icon"],
                            values["pathToJs"],
                            values["pathToCss"],
                            values["def"] == "Активен"
                            );
                        }
                    }
                }
			}
		
			this.items = 
			[
			Admin.getApplication().App._setMenuLeft(new Admin.view.AppMenuLeft()),	
			Admin.getApplication().App._setMenu(new Admin.view.AppMenu()),
			Admin.getApplication().App._setDesctop(new Admin.view.AppDesctop()),
			Admin.getApplication().App._setHeader(new Admin.view.AppHeader()),
			Admin.getApplication().App._setFooter(new Admin.view.AppFooter())
			];
		
		this.callParent();
		}
	}
);