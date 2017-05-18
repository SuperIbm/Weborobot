Ext.define('Upload.controller.Upload', 
	{
	extend: 'Ext.app.Controller',
	
	id: "Upload",
	
	views: ["UploadGrid"],
	models: ["Upload"],
	stores: ['Upload'],
	
	WindowSource: null,
	
		routes:
		{
			"!":
			{
				action: function()
				{
					if(!Ext.util.History.hasToken("uploadSource") && this.WindowSource) this.WindowSource.close();	
				}	
			},
			"uploadSource":
			{
				action: function()
				{
				this.show();
				}
			}
		},
	
		control:
		{
			"Upload\\.view\\.Panel tool[itemId='UploadSource']":
			{
				click: function(button)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "uploadSource"
							}
						]
					);
					
				this.redirectTo(token);
				}
			},
			"Upload\\.view\\.UploadGrid[name='Upload'] button[action=set]":
			{
				click: function(button)
				{
				var thisObj = this;
				var SelModel = button.up("gridpanel").getSelectionModel();
					
					Ext.Msg.show
					(
						{
						title: "Установка обновления",
						buttons: Ext.MessageBox.YESNO,
						icon: Ext.MessageBox.QUESTION,
						msg: "Вы точно уверены, что хотите установить новую версию?",
						
							fn: function(btn)
							{										
								if(btn == "yes")
								{											
								button.up("gridpanel").mask("Загрузка...");									
								var selections = SelModel.getSelection();
								
									for(var i = 0; i < selections.length; i++)
									{													
										Ext.Ajax.request
										(
											{
											url: '_api/Upload/UploadAdminController/set/',
											method: "POST",
												params:
												{
												idUpload: selections[i].id
												},
												success: function(response, options)
												{
												var result = Ext.JSON.decode(response.responseText);
												
													if(result["success"] == true)
													{						
													button.up("gridpanel").unmask();
													thisObj.getStore("Upload").load();
													
														Ext.Msg.show
														(
															{
															title: "Удачное выполнение",
															msg: "Установка обновлений была удачно произведена!",
															icon: Ext.MessageBox.INFO,
															buttons: Ext.MessageBox.OK
															}
														);
													}
													else
													{
													button.up("gridpanel").unmask();
													
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
												},
												failure: function(response, options)
												{
												button.up("gridpanel").unmask();
														
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
			},
			"Upload\\.view\\.UploadGrid[name='Upload'] button[action=check]":
			{
				click: function(button)
				{
				var thisObj = this;
				
				button.up("gridpanel").mask("Загрузка...");
				
					Ext.Ajax.request
					(
						{
						url: '_api/Upload/UploadAdminController/check/',
						method: "POST",	
							success: function(response, options)
							{
							var result = Ext.JSON.decode(response.responseText);
							
								if(result["success"] == true)
								{						
								button.up("gridpanel").unmask();
								thisObj.getStore("Upload").load();
								
									Ext.Msg.show
									(
										{
										title: "Удачное выполнение",
										msg: "Проверка обновления была удачно произведена!",
										icon: Ext.MessageBox.INFO,
										buttons: Ext.MessageBox.OK
										}
									);
								}
								else
								{
								button.up("gridpanel").unmask();
								
									if(result.errortype == "noUrl" || result.errortype == "noJson" || result.errortype == "serverError")
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
							},
							failure: function(response, options)
							{
							button.up("gridpanel").unmask();
									
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
		},
		
		show: function()
		{			
		var thisObj = this;
				
			if(!this.WindowSource)
			{
			thisObj.getApplication().createController("UploadSource");
			
				this.WindowSource = Ext.create("Upload.view.UploadSourceWindow",
					{
						listeners:
						{
							close: function()
							{
							thisObj.WindowSource = null;
								
								var token = Ext.util.History.deleteToken
								(
									[
									"uploadSource"	
									]
								);
								
							thisObj.redirectTo(token);	
							}
						}
					}
				).show().center();
			}	
		}
	}
);