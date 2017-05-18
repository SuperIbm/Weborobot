Ext.controllersIniBase = {};

Ext.define("Admin.view.ux.Application",
	{
	extend: "Ext.app.Application",
				
		getController: function(name, preventCreate)
		{
		var thisObj = this,
		controllers = thisObj.controllers,
		className, controller, len, i, c, all;
		
		controller = controllers.get(name);
		
			if (!controller) 
			{
			all = controllers.items;
				
				for (i = 0, len = all.length; i < len; ++i)
				{
				c = all[i];
				className = c.getModuleClassName();
					
					if (className && className === name)
					{
					controller = c;
					break;
					}
				}
			}	
		
		className  = thisObj.getModuleClassName(name, 'controller');
			
			if (!controller && !Ext.controllersIniBase[className])
			{
				controller = Ext.create(className, 
					{
					application: this,
					moduleClassName: name
					}
				);
			
			controllers.add(controller);
			
				if(thisObj._initialized)
				{
				Ext.controllersIniBase[className] = true;
				controller.doInit(thisObj);
				}
			}
		
		return controller;
		},
		init: function()
		{
			if(this.locals)
			{
			var Locale = Admin.getApplication().Access.getLocale();
			var localHas = false;

				for(var i = 0; i < this.locals.length; i++)
				{
					if(this.locals[i] == Locale.get())
					{
					localHas = true;
					break;
					}
				}

				if(localHas == true)
				{
				var appFolder = Ext.Loader.getPath(this.getName());

					Locale.load
					(
					appFolder + "/locale/" + Locale.get() + ".js",
						function(success)
						{
							if(success == false)
							{
								 Ext.Msg.show
								 (
									 {
										 title: "Ошибка!",
										 msg: "Произошла ошибка подгрузки файла локали.",
										 icon: Ext.MessageBox.ERROR,
										 buttons: Ext.MessageBox.OK
									 }
								 );
							}
						}
					);
				}
			}

		this.callParent();
		}
	}
);