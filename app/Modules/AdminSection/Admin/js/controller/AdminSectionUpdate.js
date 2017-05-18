Ext.define('AdminSection.controller.AdminSectionUpdate', 
	{
	extend: 'Ext.app.Controller',
	
	id: "AdminSectionUpdate",
	
	views: ["AdminSectionUpdateWindow"],
	stores: ["AdminSection"],
	
		refs: 
		{
		tab: 'AdminSection\\.view\\.AdminSectionTab'
		},
	
		control:
		{			
			"AdminSection\\.view\\.AdminSectionUpdateWindow[name='AdminSection'] button[action=send]":
			{
				click: function(button)
				{
				var thisObj = this;
				
					if(button.up("window").down("form").isValid() == true)
					{					
					button.up("window").mask("Загрузка...");
					
					var data = button.up("window").down("form").getValues();
					data["idAdminSection"] = button.up("window").down("form").getRecord().getId();
					
					var AdminSection = Ext.create(this.getModel("AdminSection"), data);														
						
						AdminSection.save
						(
							{
								success: function(model, operation)
								{
								button.up("window").unmask();
									
									Ext.Msg.show
									(
										{
										title: "Данные изменены!",
										msg: "Введенные вами данные были удачно изменены!",
										icon: Ext.MessageBox.INFO,
										buttons: Ext.MessageBox.OK
										}
									);
									
									if(thisObj.getTab())
									{
									var bundles = Admin.getApplication().Section.getBandles();
					
										for(var i = 0; i < bundles.length; i++)
										{
										var Grid = thisObj.getTab().down("gridpanel[bundleShow='" + bundles[i]["name"] + "']");
										
											if(Grid)
											{
											Grid.getStore().getProxy().setExtraParam("bundleShow", bundles[i]["name"]);
											Grid.getStore().load();
											}
										}
									}
									else
									{
									thisObj.getStore("AdminSection").load();	
									}
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
					}
				}
			},
			"AdminSection\\.view\\.AdminSectionUpdateWindow[name='AdminSection'] button[action=reset]":
			{
				click: function(button)
				{
				button.up("window").down("form").getForm().loadRecord(button.up("window").down("form").getRecord());
				}
			},
			"AdminSection\\.view\\.AdminSectionUpdateWindow[name='AdminSection'] button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);