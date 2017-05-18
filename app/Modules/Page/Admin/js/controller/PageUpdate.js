Ext.define('Page.controller.PageUpdate', 
	{
	extend: 'Ext.app.Controller',
	id: "PageUpdate",
	
	views: ["PageUpdateWindow"],
	stores: ["Page", "PageUpdateModuleAndComponentTree", "PageUpdatePageComponentTree", "PageTemplateSelect", "PageTreeComponent"],
	models: ["PageUpdateModuleAndComponentTree", "PageUpdatePageComponentTree"],
	
		routes:
		{
			"pageUpdateTab/:id":
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
					if(this.getTabUpdate()) this.getTabUpdate().setActiveTab(id);
				}
			}
		},
		
		refs: 
		{
		tabUpdate: "Page\\.view\\.PageUpdateWindow[name='Page'] Page\\.view\\.PageUpdateTab[name='Page']"
		},
		
		control:
		{
			"Page\\.view\\.PageUpdateWindow[name='Page'] Page\\.view\\.PageUpdateTab[name='Page']":
			{
				tabchange: function(TabPanel, newCard, oldCard, eOpts)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "pageUpdateTab",
							value: newCard.itemId
							}
						]
					);
				
				this.redirectTo(token);
				}
			},
			"Page\\.view\\.PageUpdateWindow[name='Page'] button[action=send]":
			{
				click: function(button)
				{				
					if(button.up("window").down("form").isValid() == true)
					{
					var thisObj = this;
					
					var data = button.up("window").down("form").getValues();
					data["idPage"] = button.up("window").down("form").getRecord().getId();
					data["idPageTemplate"] = button.up("window").down("gridpanel").getSelection().length == 0 ? null : button.up("window").down("gridpanel").getSelection()[0].getId();
					data["html"] = button.up("window").down("ckeditor").getValue();
					data["weight"] = button.up("window").down("form").getRecord().get("weight");
					
						if(!data["idPageTemplate"] && button.up("window").down("form").isRoot == true)
						{
							Ext.Msg.show
							(
								{
								title: "Предупреждение!",
								msg: "Вы должны определить шаблон для этой страницы!",
								icon: Ext.MessageBox.WARNING,
								buttons: Ext.MessageBox.OK
								}
							);
						
						button.up("window").down("tabpanel").setActiveTab(2);	
						return false;
						}
					
					button.up("window").mask("Загрузка...");
						
					var Page = Ext.create(this.getModel("Page"), data);	
					
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
								
								thisObj.getStore("Page").load();
								thisObj.getStore("PageUpdatePageComponentTree").load();
								
									button.up("window").down("form").fireEventArgs("actionForm", 
										[
										button.up("window").down("form"),
										"update"
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
			"Page\\.view\\.PageUpdateWindow[name='Page'] Page\\.view\\.PageUpdateModuleAndComponentTree tool[itemId='refresh']":
			{
				click: function(button)
				{
				button.up("panel").up("panel").down("treepanel[name='PageUpdateModuleAndComponentTree']").getStore().load();
				}	
			},
			"Page\\.view\\.PageUpdateWindow[name='Page'] Page\\.view\\.PageUpdatePageComponentTree tool[itemId='refresh']":
			{
				click: function(button)
				{
				button.up("panel").up("panel").down("treepanel[name='PageUpdatePageComponentTree']").getStore().load();
				}	
			},
			"Page\\.view\\.PageUpdateWindow[name='Page'] button[action=reset]":
			{
				click: function(button)
				{
				var form = button.up("window").down("form");
				form.loadRecord(form.getRecord());
				button.up("window").down("ckeditor").setValue(form.getRecord().get("html"));
				
				button.up("window").down("gridpanel").getSelectionModel().deselectAll();
				var recordCurrent = button.up("window").down("gridpanel").getStore().getById(form.getRecord().get("idPageTemplate"));
					
					if(recordCurrent) button.up("window").down("gridpanel").getSelectionModel().select(recordCurrent);
				}
			},
			"Page\\.view\\.PageUpdateWindow[name='Page'] button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			},
			
			"Page\\.view\\.PageUpdateWindow[name='Page'] Page\\.view\\.PageUpdatePageComponentTree":
			{
				beforeselect: function(obj, record, index, eOpts)
				{
					if(record.get("nameComponent") == undefined && record.get("nameAction") == undefined ) return false;
					
				return true;
				},
				selectionchange: function(obj, selected, eOpts)
				{				
					if(selected.length == 1)
					{					
						if(selected[0].parentNode.isRoot() == true)
						{
						selected[0].getOwnerTree().getButtonUpdate().setDisabled(true);
						selected[0].getOwnerTree().getMenuItemUpdate().setDisabled(true);
						}
					}
				}
			},
			"Page\\.view\\.PageUpdateWindow[name='Page'] Page\\.view\\.PageUpdatePageComponentTree button[action=update]":
			{
				click: function(button)
				{
					if(button.up("treepanel[name='PageUpdatePageComponentTree']").getSelection().length == 1)
					{
					var data = button.up("treepanel[name='PageUpdatePageComponentTree']").getSelection()[0];
					var Window = Admin.getApplication().Component.run(data.get("nameModule"), data.get("nameComponent"), data.get("settings"));
					
						if(Window)
						{
							if(Window.down("button[action=send]"))
							{
								Window.down("button[action=send]").on("click",
									function()
									{
										if(Window.down("form").isValid() == true)
										{
										Window.mask("Загрузка...");
										var dataForm = Window.down("form").getValues();
											
											if(!dataForm) dataForm = {};
											
										dataForm["idPageComponent"] = data.getData().id;
											
											Ext.Ajax.request
											(
												{
												url: '_api/PageComponentSetting/PageComponentSettingAdminController/update/',
												method: "POST",	
												params: dataForm, 
													success: function(response, options)
													{
													var jsonObj = Ext.util.JSON.decode(response.responseText);
													Window.unmask();
													
														if(jsonObj["success"] == true)
														{
														button.up("treepanel[name='PageUpdatePageComponentTree']").getSelection()[0].set("settings", Window.down("form").getValues());
															
															Ext.Msg.show
															(
																{
																title: "Установлено",
																msg: "Установки были успешно внесены!",
																icon: Ext.MessageBox.INFO,
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
													Window.unmask();

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
								);
							}
							else
							{
								Ext.Msg.show
								(
									{
									title: "Ошибка!",
									msg: "Окно настройки обязательно должно иметь кнопку с параметром 'action: send'!",
									icon: Ext.MessageBox.ERROR,
									buttons: Ext.MessageBox.OK
									}
								);	
							}
						}
						else
						{
							Ext.Msg.show
							(
								{
								title: "Предупреждение!",
								msg: "Этот компонент не имеет настроек!",
								icon: Ext.MessageBox.WARNING,
								buttons: Ext.MessageBox.OK
								}
							);
						}
					}
				}
			},			
			"Page\\.view\\.PageUpdateWindow[name='Page'] Page\\.view\\.PageUpdatePageComponentTree button[action=destroy]":
			{
				click: function(button)
				{
				var thisObj = this;
				var SelModel = button.up("treepanel").getSelectionModel();
				
					if(SelModel.hasSelection())
					{
						Ext.Msg.show
						(
							{
							title: "Удалить записи?",
							buttons: Ext.MessageBox.YESNO,
							icon: Ext.MessageBox.QUESTION,
							msg: "Вы точно уверены, что хотите удалить эти записи?",
							
								fn: function(btn)
								{										
									if(btn == "yes")
									{											
									button.up("treepanel").mask("Загрузка...");									
									var selections = SelModel.getSelection();
									var y = 0;
									
										for(var i = 0; i < selections.length; i++)
										{																													
											selections[i].erase
											(
												{
													success: function(record, operation)
													{
													y++;
													
														if(y == selections.length) button.up("treepanel").unmask();
													
														// Если удаление не произошло, произведем его напрямую, к сожалению это косяк ExtJs и приходится ставить костыль
														if(!operation.getResponse())
														{
														button.up("treepanel").mask("Загрузка...");
														var PageUpdatePageComponentTree = Ext.create(thisObj.getModel("PageUpdatePageComponentTree"));
														
															Ext.Ajax.request
															(
																{
																url: PageUpdatePageComponentTree.getProxy().getApi()["destroy"],
																method: "POST",
																	params:
																	{
																	id: record.getData()["id"]
																	},
																	success: function(response, options)
																	{
																	var result = Ext.JSON.decode(response.responseText);
																	
																		if(result["success"] == true)
																		{						
																		button.up("treepanel").unmask();
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
													failure: function(record, operation)
													{
													y++;
																										
														if(y == selections.length) button.up("treepanel").unmask();
																												
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
									}
								}
							}
						);
					}
				}
			}
		}
	}
);