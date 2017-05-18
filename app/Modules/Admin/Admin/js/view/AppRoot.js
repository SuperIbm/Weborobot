Ext.define('Admin.view.AppRoot', 
	{
    extend: 'Admin.view.ux.PanelAnimate',
	alias: 'widget.Admin.view.AppRoot',
	
	itemId: "AppRoot",

		items:
		[
			{
			xtype: "panelColumnAnimate",
			itemId: "left",
				items:
				[
				]
			},
			{
			xtype: "panelColumnAnimate",
			itemId: "right",
				items:
				[
				]
			}
		],

		setInSession: function()
		{
			var sessionWidget =
			{
			left: [],
			right: []
			};

			for(var i = 0; i < this.getComponent("left").items.getCount(); i++)
			{
				if(this.getComponent("left").getComponent(i).isStartDestroyed == true) continue;

				sessionWidget["left"][sessionWidget["left"].length] =
				{
                module: this.getComponent("left").getComponent(i).module,
                widget: this.getComponent("left").getComponent(i).widget,
				collapsed: this.getComponent("left").getComponent(i).getCollapsed() == "top"
				}
			}

			for(i = 0; i < this.getComponent("right").items.getCount(); i++)
			{
				if(this.getComponent("right").getComponent(i).isStartDestroyed == true) continue;

				sessionWidget["right"][sessionWidget["right"].length] =
				{
                module: this.getComponent("right").getComponent(i).module,
                widget: this.getComponent("right").getComponent(i).widget,
				collapsed: this.getComponent("right").getComponent(i).getCollapsed() == "top"
				}
			}

		Admin.getApplication().Session.set("Widget", sessionWidget);
		},

		listeners:
		{
			drop: function()
			{
			this.setInSession();
			}
		},

		initComponent: function()
		{
		var thisObj = this;
		var Widget = Admin.getApplication().Widget.get();

		var menu = [];
		var i = 0;

			for(k in Widget)
			{
				if(Admin.getApplication().Access.is(k, "isRead") == true)
				{
					for(k2 in Widget[k])
					{
						menu[i] =
						{
						text: Widget[k][k2].label,
						icon: Widget[k][k2].icon,
						name: k,
						action: k2,
							handler: function()
							{
							var Component = null;

								if(thisObj.getComponent("left").items.getCount() <= thisObj.getComponent("right").items.getCount())
								{
								Component = thisObj.getComponent("left");
								}
								else
								{
								Component = thisObj.getComponent("right");
								}

							Component.add(Admin.getApplication().Widget.create(this.name, this.action));
							thisObj.setInSession();
							}
						};

					i++;
					}
				}
			}

			this.tbar =
			[
			"->",
				{
				xtype: "button",
				text: this.addWidget,
				iconCls: "icon_widget",
				menu: menu
				}
			];

		this.callParent();

		var sessionWidget = Admin.getApplication().Session.get("Widget");

			if(sessionWidget)
			{
				for(place in sessionWidget)
				{
					if(sessionWidget[place])
                    {
                        for(var i = 0; i < sessionWidget[place].length; i++)
                        {
                            if(Admin.getApplication().Access.is(sessionWidget[place][i].module, "isRead") == true)
                            {
                            Widget = Admin.getApplication().Widget.create(sessionWidget[place][i].module, sessionWidget[place][i].widget);
                            thisObj.getComponent(place).add(Widget);

                                if(sessionWidget[place][i].collapsed == true) Widget.setCollapsed(true);
                            }
                        }
                    }
				}
			}
			else
			{
			Widget = Admin.getApplication().Widget.get();

				sessionWidget =
				{
				left: [],
				right: []
				};

				for(k in Widget)
				{
					if(Admin.getApplication().Access.is(k, "isRead") == true)
					{
						for(k2 in Widget[k])
						{
							if(Widget[k][k2].def == true)
							{
							var Component, place;

								if(thisObj.getComponent("left").items.getCount() <= thisObj.getComponent("right").items.getCount())
								{
								place = "left";
								Component = thisObj.getComponent("left");
								}
								else
								{
								Component = thisObj.getComponent("right");
								place = "right";
								}

								sessionWidget[place][sessionWidget[place].length] =
								{
								name: k,
								action: k2
								};

							Component.add(Admin.getApplication().Widget.create(k, k2));
							}
						}
					}
				}

			Admin.getApplication().Session.set("Widget", sessionWidget);
			}
		}
	}
);