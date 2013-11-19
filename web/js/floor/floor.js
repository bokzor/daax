   var layer,refreshComponents,openFloorDialog;
	PageUI.ready(function(){

		//$('#menu').hide();
		var scalingUrl = configuration.serviceUrl+'/ImageServlet?method=resize&width=80&imgUrl=';
	
		var memoryStorage={},iscroll={};

		var uploadImage=function(imageType,callback){
			var sb = [''];
			var origin = Cookie.get('origin');
			if(origin == 'restaurantbutler'){
			
				var sb=[
				'<div class="dialog standaloneImageUploader" style="width:320px;height:90px;">',
				'<div class="titlebar"><span i18n="i18n">Upload Image</span></div>',
				'<div class="imageuploader" style="padding:5px;">',
				'upload disabled on iPAD, please open the manager with a computer.',
				'</div>',
				'<div class="buttonbar"><div class="cssbutton" value="cancel" i18n="i18n">Cancel</div><div class="clearboth"></div></div>',
				'</div>'
			];
			}else{
				sb=[
					'<div class="dialog standaloneImageUploader" style="width:320px;height:90px;">',
					'<div class="titlebar"><span i18n="i18n">Upload Image</span></div>',
					'<div class="imageuploader">',
					'<div class="uploader">','<div class="label" i18n="i18n">Add Image</div><a class="lnkaddimage" href="javascript:void(0);" i18n="i18n">Choose a file</a>',
					'<input type="file" id="datafile" name="datafile" style="display:none;position:relative;float:left;top:3px;border:0 none transparent;"/>',
					'</div>',
					'</div>',
					'<div class="buttonbar"><div class="cssbutton" value="cancel" i18n="i18n">Cancel</div><div class="cssbutton" value="upload" i18n="i18n">Upload</div><div class="clearboth"></div></div>',
					'</div>'
				];
			}
			
			$('body').popupWindow({
				html:sb.join(''),
				dismissOnBlur:true,
				beforeshow:function(){
					var thisDialog=this;
					if(BrowserDetect.OS==='Windows'&&BrowserDetect.browser==='Explorer'||BrowserDetect.browser==='Safari'){
						$('#datafile',thisDialog).show();
						$('.lnkaddimage',thisDialog).hide();
					}


					$('.lnkaddimage',thisDialog).click(function(){
						$('input[type=file]',thisDialog).click();
					});
					

					$('input[type=file]',thisDialog).change(function(event){
						$('.lnkaddimage',thisDialog).text(event.currentTarget.value);
					});

					$('.cssbutton[value=upload]',thisDialog).click(function(event){
						UI.showLoadingMask(thisDialog);
						$.ajaxFileUpload({
							url:configuration.serviceUrl+'/UploadServlet',
							data:{method:'addImage',token:Cookie.get('apitoken'),type:imageType},
							secureuri:false,
							fileElementId:'datafile',
							dataType: 'json',
							success: function (data, status){
								Function.invoke(callback);
								thisDialog.animate({opacity:0},200,function(){ thisDialog.remove(); });
							},
							error: function (data, status, e){
								thisDialog.animate({opacity:0},200,function(){ thisDialog.remove(); });
								Dialog.show({
									title:localizeText('Error'),
									message:localizeText('Upload failed ! only jpg, png, gif allowed and image can not be bigger than 500kb'),
									buttons:['OK']
								});
							}
						});
					});

					$('.cssbutton[value=cancel]',thisDialog).click(function(){
						thisDialog.animate({opacity:0},200,function(){ thisDialog.remove(); });
					});
				}
			});
		};

		var refreshFloorImages=function(){
			rpc({
				method:'getImages',
				prefix:'manager',
				params:['floors'],
				applyElement:$('#floorImages .container'),
				success:function(json){
					memoryStorage['floorImages']=json;
					var cont=$('#floorImages .container>div').empty()
					.append($('<div class="new floor"><span>+</span></div>').click(function(){
						uploadImage('floors',refreshFloorImages);
					}))
					.append($($(memoryStorage.floorImages).map(function(i,e){
						return '<div class="candidate floor '+(layer!=null&&layer.data.imageLocation===e.imageLocation?'selected':'')+'"><img src=\"'+e.imageLocationMin+'\" alt=\"'+e.name+'\"/><div class="selectedIndicator"></div></div>'
					}).get().join('')).click(function(event){
						console.log()
						if(layer!=null){
							$('#floorImages .container .candidate.floor.selected').removeClass('selected');
							$(event.currentTarget).addClass('selected');
							layer.setBackgroundImage($('img',event.currentTarget).attr('src').replace('thumb/80x50_',""));
						}
					}));
				}
			});
		};

		var refreshTableImages=function(){
			rpc({
				method:'getImages',
				prefix:'manager',
				params:['tables'],
				applyElement:$('#tableImages .container'),
				success:function(json){
					memoryStorage['tableImages']=json;

					$('#tableImages .container>div').empty()
					.append($('<div class="new table"><span>+</span></div>').click(function(){
						uploadImage('tables',refreshTableImages);
					}))
					.append($($(memoryStorage.tableImages).map(function(i,e){
						return '<div class="candidate table"><img src=\"'+e.imageLocation+'\" alt=\"'+e.name+'\"/></div>'
					}).get().join('')).click(function(event){
						if(layer!=null){
							var tableImage=new Image();
							tableImage.src=$(event.currentTarget).children('img').attr('src');

							var newTable=new floorEditor.Table({
							    "status": "free",
							    "width": tableImage.width,
							    "type": null,
							    "description": null,
							    "floorId": layer.data.oid,
							    "height":tableImage.height,
							    "numberOfClients": 4,
							    "oid": '-1',
							    "rotation": 0,
							    "name": "",
							    "companyId": 10,
							    "locked": false,
							    "imageLocation":$(event.currentTarget).children('img').attr('src'),
							    "tableIds": null,
							    "y": 296,
							    "chairImageLocation":configuration.imgUrl+"/posimages/MAIN/images/whitechair.png",
							    "x": 637,
							    "zindex": 0,
							    "tableOrder": 0
							});
							newTable.setFloor(layer);
							newTable.openDialog();
						}
					}));
				}
			});
		};


		var refreshDecorationImages=function(){
			rpc({
				method:'getImages',
				prefix:'manager',
				params:['decoration'],
				applyElement:$('#decorationImages .container'),
				success:function(json){
					memoryStorage['decorationImages']=json;

					$('#decorationImages .container>div').empty()
					.append($('<div class="new decoration"><span>+</span></div>').click(function(){
						uploadImage('decoration',refreshDecorationImages);
					}))
					.append($($(memoryStorage.decorationImages).map(function(i,e){
						return '<div class="candidate decoration"><img src=\"'+e.imageLocation+'\" alt=\"'+e.name+'\"/></div>'
					}).get().join('')).click(function(event){
						if(layer!=null){
							var decoImage=new Image();
							decoImage.src=$(event.currentTarget).children('img').attr('src');

							var newDeco=new floorEditor.Decoration({
							    "floorId": layer.data.oid,
							    "height": decoImage.height,
							    "oid": -1,
							    "name": null,
							    "width": decoImage.width,
							    "imageLocation":$(event.currentTarget).children('img').attr('src'),
							    "type": "flower",
							    "y": 62,
							    "description": "",
							    "x": 98,
							    "zindex": 1
							});
							newDeco.setFloor(layer);
							newDeco.openDialog();
						}
					}));
				}
			});
		};

		refreshFloorImages();
		refreshTableImages();
		refreshDecorationImages();


		refreshComponents=function(applyElement,callback){
			callback=callback||(function(){
				$($('.floorselects .floor.existed').get(0)).click();
				$('#floorImages .menu').click();
			});

			var invokeFunction=function(){
				$('#viewport').empty();

				var floorButtons=$($(memoryStorage.floors).map(function(i,e){
					return '<div class="floor existed" oid="'+e.oid+'"><span>'+e.name+'</span><div class="background"></div></div>';
				}).get().join(''))
				.click(function(event){
					var selected=$('#board .floorselects div.floor.selected');
					if(selected.length==0||selected[0]!=event.currentTarget){
						selected.removeClass('selected');
						$(event.currentTarget).addClass('selected');
						renderFloor(memoryStorage.floors[$(event.currentTarget).index()]);
					}
				});

				$('#board .floorselects').empty()
					.append(floorButtons)
					.append($('<div class="floor add"><span>+</span><div class="background"></div></div>').click(function(event){
						var floorData={
						    "floorObjects": [],
						    "tables": [],
						    "height": 689,
						    "visible": false,
						    "oid": -1,
						    "name": "",
						    "width": 1024,
						    "backgroundImage": null,
						    "companyId": -1,
						    "imageLocation": memoryStorage['floorImages']!==undefined? memoryStorage['floorImages'][0].imageLocation :null,
						    "description": ""
						};
						openFloorDialog(floorData);
					}))
					.append('<div class="clearboth"></div>');
				Function.invoke(callback);
			};
			rpc({
				method:'getFloors',
				prefix:'manager',
				applyElement:applyElement||$('.mainbody'),
				success:function(json){
					
					memoryStorage['floors']=json;
					invokeFunction();
				}
			});
		};

		openFloorDialog=function(floor){
			var isNewFloor=floor.oid===-1;
			var sb=[
				'<div class="dialog">',
				'<div class="titlebar" i18n="i18n">'+(isNewFloor?'Add Floor':'Edit Floor')+'</div>',
				'<div class="message">',
				'<div>',
				'<div class="fv"><span class="f" i18n="i18n">Name *</span><input type="text" class="v" name="name" /></div>',
				'<div class="fv"><span class="f" i18n="i18n">Description</span><input type="text" class="v" name="description" /></div>',
				'<div class="fv"><span class="f" i18n="i18n">Width</span><input type="text" class="v" name="width" /></div>',
				'<div class="fv"><span class="f" i18n="i18n">Height</span><input type="text" class="v" name="height" /></div>',
				'<div class="fv"><span class="f" i18n="i18n">Visible</span><input type="checkbox" class="v" name="visible" /></div>',
				'</div>',
				'</div>',
				'<div class="buttonbar"><div class="cssbutton" value="delete" style="display:none;" i18n="i18n">Delete</div><div class="cssbutton" value="cancel" i18n="i18n">Cancel</div><div class="cssbutton" value="ok" i18n="i18n">OK</div><div class="clearboth"></div></div>',
				'</div>'
			];

			$('body').popupWindow({
				html:sb.join(''),
				dismissOnBlur:false,
				beforeshow:function(){
					var thisDialog=this;
					DataBinding.visualize(thisDialog,floor);

					$('.cssbutton[value=cancel]').click(function(){
						thisDialog.animate({opacity:0},200,function(){thisDialog.remove();});
					});

					$('.cssbutton[value=delete]').click(function(){

						var areAllTableFree=true;
						$(floor.tables).each(function(i,e){
							areAllTableFree&=(e.status==='free');
						});
						
						if(areAllTableFree==false){
							Dialog.show({
	                            title:localizeText('Error'),
	                            message:localizeText('Not all of the tables are free.  Cannot delete this floor!'),
	                            buttons:['OK']
	                        });
						}else{
							Dialog.show({
								title:localizeText('Confirm'),
								message:localizeText('Do you really want to delete this floor?'),
								listener:function(button){
									if(button==='ok'){
										rpc({
											method:'forceDeleteFloor',
											prefix:'manager',
											params:[floor.oid],
											applyElement:$('.dialog',thisDialog),
											success:function(){
												refreshComponents($('.dialog',thisDialog),function(){
													thisDialog.animate({opacity:0},200,function(){thisDialog.remove();});
													$('.floorselects .floor.existed').get(0).click();
												});
											}
										});
									}
								}
							});
						}
					}).css({display:isNewFloor?'none':'block'});

					$('.cssbutton[value=ok]').click(function(){
						DataBinding.datalize(thisDialog,floor);
						
						var isvalid = true, control;
                    
                  		if((control=$('input[name=name]',thisDialog)).attr('value')===''){
							control.addClass('err');
							isvalid=false;
						}
                  		
						if(isvalid){
							rpc({
								method:isNewFloor?'addFloor':'setFloor',
								prefix:'manager',
								params:[floor],
								applyElement:$('.dialog',thisDialog),
								success:function(json){
									refreshComponents($('.dialog',thisDialog),function(){
										thisDialog.animate({opacity:0},200,function(){thisDialog.remove();});
										$('.floorselects .floor.existed[oid='+(isNewFloor?json:floor.oid)+']').click();
									});
								}
							});
						}
					});
				}
			});
		}

		function renderFloor(floor){
			layer=new floorEditor.FloorLayer(floor);
			$('#viewport').empty().append(layer.sandbox);
			layer.refresh();

			$('#floorImages .container .candidate.floor.selected').removeClass('selected');

			var matchedImages=$('#floorImages .container .candidate.floor img').map(function(i,e){
				var el=$(e);
				return el.attr('src')===floor.imageLocation?el.parent():null;
			}).get();

			if(matchedImages.length>0){
				matchedImages[0].addClass('selected');
			}
		}

		$('.scaleselects .zoom.in,.scaleselects .zoom.out').click(function(event){
			var lvs=$('.scaleselects .zoom.lv');
			var currentLv=lvs.filter('.selected');
			var nextLv=currentLv[$(event.currentTarget).hasClass('in')?'prev':'next']();
			var scale;
			if(nextLv.hasClass('lv')){
				currentLv.removeClass('selected');
				scale=parseFloat( nextLv.addClass('selected').attr('scale'),10);

				floorEditor.scale=scale;
				layer.refresh();
			}
		});

		var menuCollapsedHeight=33;
		$('#elementscontainer .menu').click(function(event){
			var clickEl=$(event.currentTarget);
			if(clickEl.parent().hasClass('expanded')){
				return;
			}

			var accordionContainer=clickEl.parents('#elementscontainer');
			var accordion=accordionContainer.children('.menuaccordion');
			
			$('#elementscontainer .menuaccordion.expanded').removeClass('expanded').animate({height:menuCollapsedHeight},200);
			clickEl.parent().addClass('expanded').animate({height:accordionContainer.height()-(accordion.length-1)*menuCollapsedHeight},200,function(){
				iscroll[clickEl.parent().attr('id')].refresh();
			});

			
		});

		$(window).resize(function(){
			$('#elementscontainer .menuaccordion.expanded').height($('#elementscontainer').height()-($('#elementscontainer .menuaccordion').length-1)*menuCollapsedHeight);
		});


		
		refreshComponents();

		$('.menuaccordion .container').each(function(i,e){
			iscroll[$(e).parent().attr('id')]=UI.scroll(e);
		});
	});