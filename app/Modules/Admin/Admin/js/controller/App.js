Ext.define('Admin.controller.App', 
	{
	extend: 'Ext.app.Controller',
	
		views: 
		[
		'AppViewport'
		],
	
		routes:
		{
			"!":
			{
				before: function(action)
				{							
					if(Admin.getApplication().App.isReady() == false)
					{
						Admin.getApplication().App.ready = function()
						{
						action.resume();	
						};
					}
					else
					{
					action.resume();	
					}
				},
				action: function()
				{				
					if(Ext.util.History.getToken() == "!|") Admin.getApplication().Section.selectSection("root");	
				}
			},
			"section/:name":
			{
				before: function(name, action)
				{							
					if(Admin.getApplication().App.isReady() == false)
					{
						Admin.getApplication().App.ready = function()
						{
						action.resume();	
						};
					}
					else
					{
					action.resume();	
					}
				},
				action: function(name)
				{				
				Admin.getApplication().Section.selectSection(name);	
				}
			},
			"menu/:name":
			{
				before: function(name, action)
				{				
					if(Admin.getApplication().App.isReady() == false)
					{
						Admin.getApplication().App.ready = function()
						{
						action.resume();	
						};
					}
					else
					{
					action.resume();	
					}
				},
				action: function(name)
				{
				Admin.getApplication().Section.selectMenu(name);	
				}
			}
		},
		
		listen: 
		{
			controller: 
			{
				'*':
				{
					unmatchedroute: function(hash)
					{															
						if(Ext.util.History.getToken() == "")
						{
						Admin.getApplication().Section.selectSection("root");
						}
					}
				}
			}
		},
		
		control:
		{
			"Admin\\.view\\.AppHeader button[action=exit]":
			{
				click: function(button)
				{
					Ext.Msg.show
					(
						{
						title: "Предупреждение!",
						msg: "Вы точно хотите выйти из системы?",
						icon: Ext.MessageBox.QUESTION,
						buttons: Ext.MessageBox.OKCANCEL,
							fn: function(buttonId)
							{
								if(buttonId == "ok")
								{
								Admin.getApplication().Access.exit();
								}
							}
						}
					);
				}
			},
			"Admin\\.view\\.AppHeader button[action=menu] menu":
			{
				click: function(menu, item, e, eOpts)
				{				
					if(item.section)
					{					
						if(item.index == "root") this.redirectTo("!|");
						else this.redirectTo("!|section/" + item.index);
					}
					else
					{
					this.redirectTo("!|menu/" + item.bundle.name);
					}
				}
			},
			"Admin\\.view\\.AppHeader button[action=locale] menu":
			{
				click: function(menu, item, e, eOpts)
				{
				Admin.getApplication().Access.getLocale().set(item.index);

					window.location.search = Ext.Object.toQueryString
					(
						{
						"lang": item.index
						}
					);
				}
			},
			"Admin\\.view\\.AppHeader button[action=home]":
			{
				click: function(menu, item, e, eOpts)
				{
				this.redirectTo("!|");
				}
			},
			"Admin\\.view\\.AppHeader button[action=destroy_cache]":
			{
				click: function(menu, item, e, eOpts)
				{
				Admin.getApplication().App.getViewport().mask("Загрузка...");	
				
					Ext.Ajax.request
					(
						{
						url: '_api/Cache/CacheController/destroy/',
						method: "POST",	
							success: function(response, options)
							{
							Admin.getApplication().App.getViewport().unmask();
							var result = Ext.JSON.decode(response.responseText);
							
								if(result.success == true)
								{
									Ext.Msg.show
									(
										{
										title: "Кеш очищен!",
										msg: "Закешированные данные были удачно удалены!",
										icon: Ext.MessageBox.INFO,
										buttons: Ext.MessageBox.OK
										}
									);
								}
								else if(result.errormsg)
								{
									Ext.Msg.show
									(
										{
										title: "Ошибка!",
										msg: result.errormsg,
										icon: Ext.MessageBox.ERROR,
										buttons: Ext.MessageBox.OK
										}
									);
								}
								else
								{
                                    Ext.Msg.show
                                    (
                                        {
										title: "Ошибка!",
										msg: "Произошла ошибка выполнения программы на сервере!",
										icon: Ext.MessageBox.ERROR,
										buttons: Ext.MessageBox.OK
                                        }
                                    );
								}
							},
							failure: function(response, options)
							{
							Admin.getApplication().App.getViewport().unmask();
									
								Ext.Msg.show
								(
									{
									title: "Ошибка!",
									msg: "Произошла ошибка выполнения программы на сервере!",
									icon: Ext.MessageBox.ERROR,
									buttons: Ext.MessageBox.OK
									}
								);
							}
						}
					);
				}
			},
			"Admin\\.view\\.AppMenuLeft button":
			{
				click: function(button)
				{
					if(button.action == "exit")
					{
						Ext.Msg.show
						(
							{
							title: "Предупреждение!",
							msg: "Вы точно хотите выйти из системы?",
							icon: Ext.MessageBox.QUESTION,
							buttons: Ext.MessageBox.OKCANCEL,
								fn: function(buttonId)
								{								
									if(buttonId == "ok")
									{
									Admin.getApplication().Access.exit();
									}
								}
							}
						);
					}
					else
					{
						if(button.action == "root") this.redirectTo("!|");
						else this.redirectTo("!|section/" + button.action);
					}
				}
			},
			"Admin\\.view\\.AppMenu treepanel":
			{
				beforeselect: function(modelSel, record, index, eOpts)
				{
					if(record.getId() == "root") this.redirectTo("!|");
					else this.redirectTo("!|section/" + record.getId());
				}
			},
			"Admin\\.view\\.AppDesctop Admin\\.view\\.AppBreadCrumb":
			{
				selectionchange: function(breadcrumb, node, config)
				{								
					if(node.getData().id == "root")
					{
					this.redirectTo("!|");
					}
					else if(node.getData().section)
					{
					this.redirectTo("!|section/" + node.getData().id);
					}
					else
					{
					this.redirectTo("!|menu/" + node.getData()["bundle"]["name"]);
					}
				}
			}
		}
	}
);