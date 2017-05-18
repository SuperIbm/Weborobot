Ext.define('Page.controller.PageCreate', 
	{
	extend: 'Ext.app.Controller',
	id: "PageCreate",
	
	views: ["PageCreateWindow"],
	stores: ["Page", "PageTemplateSelect"],
	
		routes:
		{
			"pageCreateTab/:id":
			{
				before: function(id, action)
				{				
					if(this.getStore("Page").isLoaded() == false)
					{
						this.getStore("Page").on("load",
							function()
							{
							action.resume();	
							},
							null,
							{
							single: true	
							}
						);
					}
					else action.resume();
				},
				action: function(id)
				{
					if(this.getTabCreate()) this.getTabCreate().setActiveTab(id);
				}
			}
		},
		
		refs: 
		{
		tabCreate: "Page\\.view\\.PageCreateWindow[name='Page'] Page\\.view\\.PageCreateTab[name='Page']"
		},
		
		control:
		{
			"Page\\.view\\.PageCreateWindow[name='Page'] Page\\.view\\.PageCreateTab[name='Page']":
			{
				tabchange: function(TabPanel, newCard, oldCard, eOpts)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "pageCreateTab",
							value: newCard.itemId
							}
						]
					);
							
				this.redirectTo(token);
				}
			},
			"Page\\.view\\.PageCreateWindow[name='Page'] button[action=send]":
			{
				click: function(button)
				{				
					if(button.up("window").down("form").isValid() == true)
					{
					var thisObj = this;
					
					button.up("window").mask("Загрузка...");
					
					var data = button.up("window").down("form").getValues();
					data["idPageTemplate"] = button.up("window").down("gridpanel").getSelection().length == 0 ? null : button.up("window").down("gridpanel").getSelection()[0].getId();
					data["idPageReferen"] = button.up("window").down("form").getForm().id;
					data["html"] = button.up("window").down("ckeditor").getValue();
					
					var Page = Ext.create(this.getModel("Page"), data);	
					Page.setId(null);
					
						Page.save
						(
							{
								success: function(model, operation)
								{
								button.up("window").unmask();
									
									Ext.Msg.show
									(
										{
										title: "Данные добавлены!",
										msg: "Введенные вами данные были удачно добавлены!",
										icon: Ext.MessageBox.INFO,
										buttons: Ext.MessageBox.OK
										}
									);
									
								button.up("window").down("form").reset();
								button.up("window").down("ckeditor").setValue("");
								
								button.up("window").down("gridpanel").getSelectionModel().deselectAll();
								thisObj.getStore("Page").load();
								
									button.up("window").down("form").fireEventArgs("actionForm", 
										[
										button.up("window").down("form"),
										"create"
										]
									);
								},
								failure: function(model, operation)
								{
								var result = Ext.decode(operation.getResponse().responseText);							
								button.up("window").unmask();
									
									if(result.errormsg)
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
								}
							}
						);
					}
					else
					{
						Ext.Msg.show
						(
							{
							title: "Предупреждение!",
							msg: "Некоторые поля в форме заполнены некорректно!",
							icon: Ext.MessageBox.WARNING,
							buttons: Ext.MessageBox.OK
							}
						);
						
					button.up("window").down("tabpanel").setActiveTab(1);
					}
				}
			},
			"Page\\.view\\.PageCreateWindow[name='Page'] button[action=reset]":
			{
				click: function(button)
				{
				button.up("window").down("form").reset();
				button.up("window").down("ckeditor").setValue("");
				button.up("window").down("gridpanel").getSelectionModel().deselectAll();
				}
			},
			"Page\\.view\\.PageCreateWindow[name='Page'] button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);