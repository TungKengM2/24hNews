<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="{{ asset('admin/images/favicon.ico') }}">

  <title>CrmX Admin - Dashboard Data Tables</title>

  <!-- Vendors Style -->
  <link rel="stylesheet" href="{{ asset('admin/main/css/vendors_css.css') }}">
  
  <!-- Style -->  
  <link rel="stylesheet" href="{{ asset('admin/main/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/main/css/skin_color.css') }}">
</head>

<body class="hold-transition dark-skin sidebar-mini theme-primary fixed">
  
<div class="wrapper">
  <div id="loader"></div>
   
  @include('admin.layouts.partials.header')

  <!-- Left side column. contains the logo and sidebar -->
  @include('admin.layouts.partials.aside')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
			<div class="container-full">
				<!-- Content Header (Page header) -->
				<div class="content-header">
					<div class="d-flex align-items-center">
						<div class="me-auto">
							<h4 class="page-title">Editors</h4>
							<div class="d-inline-block align-items-center">
								<nav>
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="forms_editors.html#"><i class="mdi mdi-home-outline"></i></a>
										</li>
										<li class="breadcrumb-item" aria-current="page">Forms</li>
										<li class="breadcrumb-item active" aria-current="page">
											Editors
										</li>
									</ol>
								</nav>
							</div>
						</div>
					</div>
				</div>

				<!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-12">
							<div class="box">
								<div class="box-header">
									<h4 class="box-title">CK Editor<br>
										<small>Advanced and full of features</small>
									</h4>
								</div>
								<!-- /.box-header -->
								<div class="box-body">
									<form>
										<textarea id="editor1" name="editor1" rows="10" cols="80"
											style="visibility: hidden; display: none;">												This is my textarea to be replaced with CKEditor.
										</textarea>
										<div id="cke_editor1"
											class="cke_1 cke cke_reset cke_chrome cke_editor_editor1 cke_ltr cke_browser_webkit"
											dir="ltr" lang="en" role="application"
											aria-labelledby="cke_editor1_arialbl"><span id="cke_editor1_arialbl"
												class="cke_voice_label">Rich Text Editor, editor1</span>
											<div class="cke_inner cke_reset" role="presentation"><span id="cke_1_top"
													class="cke_top cke_reset_all" role="presentation"
													style="height: auto; user-select: none;"><span id="cke_12"
														class="cke_voice_label">Editor toolbars</span><span
														id="cke_1_toolbox" class="cke_toolbox" role="group"
														aria-labelledby="cke_12" onmousedown="return false;"><span
															id="cke_17" class="cke_toolbar"
															aria-labelledby="cke_17_label" role="toolbar"><span
																id="cke_17_label"
																class="cke_voice_label">Document</span><span
																class="cke_toolbar_start"></span><span
																class="cke_toolgroup" role="presentation"><a id="cke_18"
																	class="cke_button cke_button__source cke_button_off"
																	href="javascript:void('Source')" title="Source"
																	tabindex="-1" hidefocus="true" role="button"
																	aria-labelledby="cke_18_label"
																	aria-describedby="cke_18_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(2,event);"
																	onfocus="return CKEDITOR.tools.callFunction(3,event);"
																	onclick="CKEDITOR.tools.callFunction(4,this);return false;"><span
																		class="cke_button_icon cke_button__source_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -1848px;background-size:auto;">&nbsp;</span><span
																		id="cke_18_label"
																		class="cke_button_label cke_button__source_label"
																		aria-hidden="false">Source</span><span
																		id="cke_18_description" class="cke_button_label"
																		aria-hidden="false"></span></a><span
																	class="cke_toolbar_separator"
																	role="separator"></span><a id="cke_19"
																	class="cke_button cke_button__save cke_button_off"
																	href="javascript:void('Save')" title="Save"
																	tabindex="-1" hidefocus="true" role="button"
																	aria-labelledby="cke_19_label"
																	aria-describedby="cke_19_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(5,event);"
																	onfocus="return CKEDITOR.tools.callFunction(6,event);"
																	onclick="CKEDITOR.tools.callFunction(7,this);return false;"><span
																		class="cke_button_icon cke_button__save_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -1728px;background-size:auto;">&nbsp;</span><span
																		id="cke_19_label"
																		class="cke_button_label cke_button__save_label"
																		aria-hidden="false">Save</span><span
																		id="cke_19_description" class="cke_button_label"
																		aria-hidden="false"></span></a><a id="cke_20"
																	class="cke_button cke_button__newpage cke_button_off"
																	href="javascript:void('New Page')" title="New Page"
																	tabindex="-1" hidefocus="true" role="button"
																	aria-labelledby="cke_20_label"
																	aria-describedby="cke_20_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(8,event);"
																	onfocus="return CKEDITOR.tools.callFunction(9,event);"
																	onclick="CKEDITOR.tools.callFunction(10,this);return false;"><span
																		class="cke_button_icon cke_button__newpage_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -1464px;background-size:auto;">&nbsp;</span><span
																		id="cke_20_label"
																		class="cke_button_label cke_button__newpage_label"
																		aria-hidden="false">New Page</span><span
																		id="cke_20_description" class="cke_button_label"
																		aria-hidden="false"></span></a><a id="cke_21"
																	class="cke_button cke_button__preview cke_button_off"
																	href="javascript:void('Preview')" title="Preview"
																	tabindex="-1" hidefocus="true" role="button"
																	aria-labelledby="cke_21_label"
																	aria-describedby="cke_21_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(11,event);"
																	onfocus="return CKEDITOR.tools.callFunction(12,event);"
																	onclick="CKEDITOR.tools.callFunction(13,this);return false;"><span
																		class="cke_button_icon cke_button__preview_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -1656px;background-size:auto;">&nbsp;</span><span
																		id="cke_21_label"
																		class="cke_button_label cke_button__preview_label"
																		aria-hidden="false">Preview</span><span
																		id="cke_21_description" class="cke_button_label"
																		aria-hidden="false"></span></a><a id="cke_22"
																	class="cke_button cke_button__print cke_button_off"
																	href="javascript:void('Print')" title="Print"
																	tabindex="-1" hidefocus="true" role="button"
																	aria-labelledby="cke_22_label"
																	aria-describedby="cke_22_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(14,event);"
																	onfocus="return CKEDITOR.tools.callFunction(15,event);"
																	onclick="CKEDITOR.tools.callFunction(16,this);return false;"><span
																		class="cke_button_icon cke_button__print_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -1680px;background-size:auto;">&nbsp;</span><span
																		id="cke_22_label"
																		class="cke_button_label cke_button__print_label"
																		aria-hidden="false">Print</span><span
																		id="cke_22_description" class="cke_button_label"
																		aria-hidden="false"></span></a><span
																	class="cke_toolbar_separator"
																	role="separator"></span><a id="cke_23"
																	class="cke_button cke_button__templates cke_button_off"
																	href="javascript:void('Templates')"
																	title="Templates" tabindex="-1" hidefocus="true"
																	role="button" aria-labelledby="cke_23_label"
																	aria-describedby="cke_23_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(17,event);"
																	onfocus="return CKEDITOR.tools.callFunction(18,event);"
																	onclick="CKEDITOR.tools.callFunction(19,this);return false;"><span
																		class="cke_button_icon cke_button__templates_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -456px;background-size:auto;">&nbsp;</span><span
																		id="cke_23_label"
																		class="cke_button_label cke_button__templates_label"
																		aria-hidden="false">Templates</span><span
																		id="cke_23_description" class="cke_button_label"
																		aria-hidden="false"></span></a></span><span
																class="cke_toolbar_end"></span></span><span id="cke_24"
															class="cke_toolbar" aria-labelledby="cke_24_label"
															role="toolbar"><span id="cke_24_label"
																class="cke_voice_label">Clipboard/Undo</span><span
																class="cke_toolbar_start"></span><span
																class="cke_toolgroup" role="presentation"><a id="cke_25"
																	class="cke_button cke_button__cut cke_button_disabled "
																	href="javascript:void('Cut')" title="Cut (Ctrl+X)"
																	tabindex="-1" hidefocus="true" role="button"
																	aria-labelledby="cke_25_label"
																	aria-describedby="cke_25_description"
																	aria-haspopup="false" aria-disabled="true"
																	onkeydown="return CKEDITOR.tools.callFunction(20,event);"
																	onfocus="return CKEDITOR.tools.callFunction(21,event);"
																	onclick="CKEDITOR.tools.callFunction(22,this);return false;"><span
																		class="cke_button_icon cke_button__cut_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -312px;background-size:auto;">&nbsp;</span><span
																		id="cke_25_label"
																		class="cke_button_label cke_button__cut_label"
																		aria-hidden="false">Cut</span><span
																		id="cke_25_description" class="cke_button_label"
																		aria-hidden="false">Keyboard shortcut
																		Ctrl+X</span></a><a id="cke_26"
																	class="cke_button cke_button__copy cke_button_disabled "
																	href="javascript:void('Copy')" title="Copy (Ctrl+C)"
																	tabindex="-1" hidefocus="true" role="button"
																	aria-labelledby="cke_26_label"
																	aria-describedby="cke_26_description"
																	aria-haspopup="false" aria-disabled="true"
																	onkeydown="return CKEDITOR.tools.callFunction(23,event);"
																	onfocus="return CKEDITOR.tools.callFunction(24,event);"
																	onclick="CKEDITOR.tools.callFunction(25,this);return false;"><span
																		class="cke_button_icon cke_button__copy_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -264px;background-size:auto;">&nbsp;</span><span
																		id="cke_26_label"
																		class="cke_button_label cke_button__copy_label"
																		aria-hidden="false">Copy</span><span
																		id="cke_26_description" class="cke_button_label"
																		aria-hidden="false">Keyboard shortcut
																		Ctrl+C</span></a><a id="cke_27"
																	class="cke_button cke_button__paste cke_button_off"
																	href="javascript:void('Paste')"
																	title="Paste (Ctrl+V)" tabindex="-1"
																	hidefocus="true" role="button"
																	aria-labelledby="cke_27_label"
																	aria-describedby="cke_27_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(26,event);"
																	onfocus="return CKEDITOR.tools.callFunction(27,event);"
																	onclick="CKEDITOR.tools.callFunction(28,this);return false;"><span
																		class="cke_button_icon cke_button__paste_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -360px;background-size:auto;">&nbsp;</span><span
																		id="cke_27_label"
																		class="cke_button_label cke_button__paste_label"
																		aria-hidden="false">Paste</span><span
																		id="cke_27_description" class="cke_button_label"
																		aria-hidden="false">Keyboard shortcut
																		Ctrl+V</span></a><a id="cke_28"
																	class="cke_button cke_button__pastetext cke_button_off"
																	href="javascript:void('Paste as plain text')"
																	title="Paste as plain text (Ctrl+Shift+V)"
																	tabindex="-1" hidefocus="true" role="button"
																	aria-labelledby="cke_28_label"
																	aria-describedby="cke_28_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(29,event);"
																	onfocus="return CKEDITOR.tools.callFunction(30,event);"
																	onclick="CKEDITOR.tools.callFunction(31,this);return false;"><span
																		class="cke_button_icon cke_button__pastetext_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -1560px;background-size:auto;">&nbsp;</span><span
																		id="cke_28_label"
																		class="cke_button_label cke_button__pastetext_label"
																		aria-hidden="false">Paste as plain
																		text</span><span id="cke_28_description"
																		class="cke_button_label"
																		aria-hidden="false">Keyboard shortcut
																		Ctrl+Shift+V</span></a><a id="cke_29"
																	class="cke_button cke_button__pastefromword cke_button_off"
																	href="javascript:void('Paste from Word')"
																	title="Paste from Word" tabindex="-1"
																	hidefocus="true" role="button"
																	aria-labelledby="cke_29_label"
																	aria-describedby="cke_29_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(32,event);"
																	onfocus="return CKEDITOR.tools.callFunction(33,event);"
																	onclick="CKEDITOR.tools.callFunction(34,this);return false;"><span
																		class="cke_button_icon cke_button__pastefromword_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -1608px;background-size:auto;">&nbsp;</span><span
																		id="cke_29_label"
																		class="cke_button_label cke_button__pastefromword_label"
																		aria-hidden="false">Paste from Word</span><span
																		id="cke_29_description" class="cke_button_label"
																		aria-hidden="false"></span></a><span
																	class="cke_toolbar_separator"
																	role="separator"></span><a id="cke_30"
																	class="cke_button cke_button__undo cke_button_disabled "
																	href="javascript:void('Undo')" title="Undo (Ctrl+Z)"
																	tabindex="-1" hidefocus="true" role="button"
																	aria-labelledby="cke_30_label"
																	aria-describedby="cke_30_description"
																	aria-haspopup="false" aria-disabled="true"
																	onkeydown="return CKEDITOR.tools.callFunction(35,event);"
																	onfocus="return CKEDITOR.tools.callFunction(36,event);"
																	onclick="CKEDITOR.tools.callFunction(37,this);return false;"><span
																		class="cke_button_icon cke_button__undo_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -2016px;background-size:auto;">&nbsp;</span><span
																		id="cke_30_label"
																		class="cke_button_label cke_button__undo_label"
																		aria-hidden="false">Undo</span><span
																		id="cke_30_description" class="cke_button_label"
																		aria-hidden="false">Keyboard shortcut
																		Ctrl+Z</span></a><a id="cke_31"
																	class="cke_button cke_button__redo cke_button_disabled "
																	href="javascript:void('Redo')" title="Redo (Ctrl+Y)"
																	tabindex="-1" hidefocus="true" role="button"
																	aria-labelledby="cke_31_label"
																	aria-describedby="cke_31_description"
																	aria-haspopup="false" aria-disabled="true"
																	onkeydown="return CKEDITOR.tools.callFunction(38,event);"
																	onfocus="return CKEDITOR.tools.callFunction(39,event);"
																	onclick="CKEDITOR.tools.callFunction(40,this);return false;"><span
																		class="cke_button_icon cke_button__redo_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -1968px;background-size:auto;">&nbsp;</span><span
																		id="cke_31_label"
																		class="cke_button_label cke_button__redo_label"
																		aria-hidden="false">Redo</span><span
																		id="cke_31_description" class="cke_button_label"
																		aria-hidden="false">Keyboard shortcut
																		Ctrl+Y</span></a></span><span
																class="cke_toolbar_end"></span></span><span id="cke_32"
															class="cke_toolbar" aria-labelledby="cke_32_label"
															role="toolbar"><span id="cke_32_label"
																class="cke_voice_label">Editing</span><span
																class="cke_toolbar_start"></span><span
																class="cke_toolgroup" role="presentation"><a id="cke_33"
																	class="cke_button cke_button__find cke_button_off"
																	href="javascript:void('Find')" title="Find"
																	tabindex="-1" hidefocus="true" role="button"
																	aria-labelledby="cke_33_label"
																	aria-describedby="cke_33_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(41,event);"
																	onfocus="return CKEDITOR.tools.callFunction(42,event);"
																	onclick="CKEDITOR.tools.callFunction(43,this);return false;"><span
																		class="cke_button_icon cke_button__find_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -552px;background-size:auto;">&nbsp;</span><span
																		id="cke_33_label"
																		class="cke_button_label cke_button__find_label"
																		aria-hidden="false">Find</span><span
																		id="cke_33_description" class="cke_button_label"
																		aria-hidden="false"></span></a><a id="cke_34"
																	class="cke_button cke_button__replace cke_button_off"
																	href="javascript:void('Replace')" title="Replace"
																	tabindex="-1" hidefocus="true" role="button"
																	aria-labelledby="cke_34_label"
																	aria-describedby="cke_34_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(44,event);"
																	onfocus="return CKEDITOR.tools.callFunction(45,event);"
																	onclick="CKEDITOR.tools.callFunction(46,this);return false;"><span
																		class="cke_button_icon cke_button__replace_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -576px;background-size:auto;">&nbsp;</span><span
																		id="cke_34_label"
																		class="cke_button_label cke_button__replace_label"
																		aria-hidden="false">Replace</span><span
																		id="cke_34_description" class="cke_button_label"
																		aria-hidden="false"></span></a><span
																	class="cke_toolbar_separator"
																	role="separator"></span><a id="cke_35"
																	class="cke_button cke_button__selectall cke_button_off"
																	href="javascript:void('Select All')"
																	title="Select All" tabindex="-1" hidefocus="true"
																	role="button" aria-labelledby="cke_35_label"
																	aria-describedby="cke_35_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(47,event);"
																	onfocus="return CKEDITOR.tools.callFunction(48,event);"
																	onclick="CKEDITOR.tools.callFunction(49,this);return false;"><span
																		class="cke_button_icon cke_button__selectall_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -1752px;background-size:auto;">&nbsp;</span><span
																		id="cke_35_label"
																		class="cke_button_label cke_button__selectall_label"
																		aria-hidden="false">Select All</span><span
																		id="cke_35_description" class="cke_button_label"
																		aria-hidden="false"></span></a><span
																	class="cke_toolbar_separator"
																	role="separator"></span><a id="cke_36"
																	class="cke_button cke_button__scayt cke_button_off"
																	href="javascript:void('Spell Checker')"
																	title="Spell Checker" tabindex="-1" hidefocus="true"
																	role="button" aria-labelledby="cke_36_label"
																	aria-describedby="cke_36_description"
																	aria-haspopup="true"
																	onkeydown="return CKEDITOR.tools.callFunction(50,event);"
																	onfocus="return CKEDITOR.tools.callFunction(51,event);"
																	onclick="CKEDITOR.tools.callFunction(52,this);return false;"><span
																		class="cke_button_icon cke_button__scayt_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -1896px;background-size:auto;">&nbsp;</span><span
																		id="cke_36_label"
																		class="cke_button_label cke_button__scayt_label"
																		aria-hidden="false">Spell Check As You
																		Type</span><span id="cke_36_description"
																		class="cke_button_label"
																		aria-hidden="false"></span><span
																		class="cke_button_arrow"></span></a></span><span
																class="cke_toolbar_end"></span></span><span id="cke_37"
															class="cke_toolbar cke_toolbar_last"
															aria-labelledby="cke_37_label" role="toolbar"><span
																id="cke_37_label"
																class="cke_voice_label">Forms</span><span
																class="cke_toolbar_start"></span><span
																class="cke_toolgroup" role="presentation"><a id="cke_38"
																	class="cke_button cke_button__form cke_button_off"
																	href="javascript:void('Form')" title="Form"
																	tabindex="-1" hidefocus="true" role="button"
																	aria-labelledby="cke_38_label"
																	aria-describedby="cke_38_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(53,event);"
																	onfocus="return CKEDITOR.tools.callFunction(54,event);"
																	onclick="CKEDITOR.tools.callFunction(55,this);return false;"><span
																		class="cke_button_icon cke_button__form_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -672px;background-size:auto;">&nbsp;</span><span
																		id="cke_38_label"
																		class="cke_button_label cke_button__form_label"
																		aria-hidden="false">Form</span><span
																		id="cke_38_description" class="cke_button_label"
																		aria-hidden="false"></span></a><a id="cke_39"
																	class="cke_button cke_button__checkbox cke_button_off"
																	href="javascript:void('Checkbox')" title="Checkbox"
																	tabindex="-1" hidefocus="true" role="button"
																	aria-labelledby="cke_39_label"
																	aria-describedby="cke_39_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(56,event);"
																	onfocus="return CKEDITOR.tools.callFunction(57,event);"
																	onclick="CKEDITOR.tools.callFunction(58,this);return false;"><span
																		class="cke_button_icon cke_button__checkbox_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -648px;background-size:auto;">&nbsp;</span><span
																		id="cke_39_label"
																		class="cke_button_label cke_button__checkbox_label"
																		aria-hidden="false">Checkbox</span><span
																		id="cke_39_description" class="cke_button_label"
																		aria-hidden="false"></span></a><a id="cke_40"
																	class="cke_button cke_button__radio cke_button_off"
																	href="javascript:void('Radio Button')"
																	title="Radio Button" tabindex="-1" hidefocus="true"
																	role="button" aria-labelledby="cke_40_label"
																	aria-describedby="cke_40_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(59,event);"
																	onfocus="return CKEDITOR.tools.callFunction(60,event);"
																	onclick="CKEDITOR.tools.callFunction(61,this);return false;"><span
																		class="cke_button_icon cke_button__radio_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -744px;background-size:auto;">&nbsp;</span><span
																		id="cke_40_label"
																		class="cke_button_label cke_button__radio_label"
																		aria-hidden="false">Radio Button</span><span
																		id="cke_40_description" class="cke_button_label"
																		aria-hidden="false"></span></a><a id="cke_41"
																	class="cke_button cke_button__textfield cke_button_off"
																	href="javascript:void('Text Field')"
																	title="Text Field" tabindex="-1" hidefocus="true"
																	role="button" aria-labelledby="cke_41_label"
																	aria-describedby="cke_41_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(62,event);"
																	onfocus="return CKEDITOR.tools.callFunction(63,event);"
																	onclick="CKEDITOR.tools.callFunction(64,this);return false;"><span
																		class="cke_button_icon cke_button__textfield_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -888px;background-size:auto;">&nbsp;</span><span
																		id="cke_41_label"
																		class="cke_button_label cke_button__textfield_label"
																		aria-hidden="false">Text Field</span><span
																		id="cke_41_description" class="cke_button_label"
																		aria-hidden="false"></span></a><a id="cke_42"
																	class="cke_button cke_button__textarea cke_button_off"
																	href="javascript:void('Textarea')" title="Textarea"
																	tabindex="-1" hidefocus="true" role="button"
																	aria-labelledby="cke_42_label"
																	aria-describedby="cke_42_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(65,event);"
																	onfocus="return CKEDITOR.tools.callFunction(66,event);"
																	onclick="CKEDITOR.tools.callFunction(67,this);return false;"><span
																		class="cke_button_icon cke_button__textarea_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -840px;background-size:auto;">&nbsp;</span><span
																		id="cke_42_label"
																		class="cke_button_label cke_button__textarea_label"
																		aria-hidden="false">Textarea</span><span
																		id="cke_42_description" class="cke_button_label"
																		aria-hidden="false"></span></a><a id="cke_43"
																	class="cke_button cke_button__select cke_button_off"
																	href="javascript:void('Selection Field')"
																	title="Selection Field" tabindex="-1"
																	hidefocus="true" role="button"
																	aria-labelledby="cke_43_label"
																	aria-describedby="cke_43_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(68,event);"
																	onfocus="return CKEDITOR.tools.callFunction(69,event);"
																	onclick="CKEDITOR.tools.callFunction(70,this);return false;"><span
																		class="cke_button_icon cke_button__select_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -792px;background-size:auto;">&nbsp;</span><span
																		id="cke_43_label"
																		class="cke_button_label cke_button__select_label"
																		aria-hidden="false">Selection Field</span><span
																		id="cke_43_description" class="cke_button_label"
																		aria-hidden="false"></span></a><a id="cke_44"
																	class="cke_button cke_button__button cke_button_off"
																	href="javascript:void('Button')" title="Button"
																	tabindex="-1" hidefocus="true" role="button"
																	aria-labelledby="cke_44_label"
																	aria-describedby="cke_44_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(71,event);"
																	onfocus="return CKEDITOR.tools.callFunction(72,event);"
																	onclick="CKEDITOR.tools.callFunction(73,this);return false;"><span
																		class="cke_button_icon cke_button__button_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -624px;background-size:auto;">&nbsp;</span><span
																		id="cke_44_label"
																		class="cke_button_label cke_button__button_label"
																		aria-hidden="false">Button</span><span
																		id="cke_44_description" class="cke_button_label"
																		aria-hidden="false"></span></a><a id="cke_45"
																	class="cke_button cke_button__imagebutton cke_button_off"
																	href="javascript:void('Image Button')"
																	title="Image Button" tabindex="-1" hidefocus="true"
																	role="button" aria-labelledby="cke_45_label"
																	aria-describedby="cke_45_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(74,event);"
																	onfocus="return CKEDITOR.tools.callFunction(75,event);"
																	onclick="CKEDITOR.tools.callFunction(76,this);return false;"><span
																		class="cke_button_icon cke_button__imagebutton_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -720px;background-size:auto;">&nbsp;</span><span
																		id="cke_45_label"
																		class="cke_button_label cke_button__imagebutton_label"
																		aria-hidden="false">Image Button</span><span
																		id="cke_45_description" class="cke_button_label"
																		aria-hidden="false"></span></a><a id="cke_46"
																	class="cke_button cke_button__hiddenfield cke_button_off"
																	href="javascript:void('Hidden Field')"
																	title="Hidden Field" tabindex="-1" hidefocus="true"
																	role="button" aria-labelledby="cke_46_label"
																	aria-describedby="cke_46_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(77,event);"
																	onfocus="return CKEDITOR.tools.callFunction(78,event);"
																	onclick="CKEDITOR.tools.callFunction(79,this);return false;"><span
																		class="cke_button_icon cke_button__hiddenfield_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -696px;background-size:auto;">&nbsp;</span><span
																		id="cke_46_label"
																		class="cke_button_label cke_button__hiddenfield_label"
																		aria-hidden="false">Hidden Field</span><span
																		id="cke_46_description" class="cke_button_label"
																		aria-hidden="false"></span></a></span><span
																class="cke_toolbar_end"></span></span><span
															class="cke_toolbar_break"></span><span id="cke_47"
															class="cke_toolbar" aria-labelledby="cke_47_label"
															role="toolbar"><span id="cke_47_label"
																class="cke_voice_label">Basic Styles</span><span
																class="cke_toolbar_start"></span><span
																class="cke_toolgroup" role="presentation"><a id="cke_48"
																	class="cke_button cke_button__bold cke_button_off"
																	href="javascript:void('Bold')" title="Bold (Ctrl+B)"
																	tabindex="-1" hidefocus="true" role="button"
																	aria-labelledby="cke_48_label"
																	aria-describedby="cke_48_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(80,event);"
																	onfocus="return CKEDITOR.tools.callFunction(81,event);"
																	onclick="CKEDITOR.tools.callFunction(82,this);return false;"><span
																		class="cke_button_icon cke_button__bold_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -24px;background-size:auto;">&nbsp;</span><span
																		id="cke_48_label"
																		class="cke_button_label cke_button__bold_label"
																		aria-hidden="false">Bold</span><span
																		id="cke_48_description" class="cke_button_label"
																		aria-hidden="false">Keyboard shortcut
																		Ctrl+B</span></a><a id="cke_49"
																	class="cke_button cke_button__italic cke_button_off"
																	href="javascript:void('Italic')"
																	title="Italic (Ctrl+I)" tabindex="-1"
																	hidefocus="true" role="button"
																	aria-labelledby="cke_49_label"
																	aria-describedby="cke_49_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(83,event);"
																	onfocus="return CKEDITOR.tools.callFunction(84,event);"
																	onclick="CKEDITOR.tools.callFunction(85,this);return false;"><span
																		class="cke_button_icon cke_button__italic_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -48px;background-size:auto;">&nbsp;</span><span
																		id="cke_49_label"
																		class="cke_button_label cke_button__italic_label"
																		aria-hidden="false">Italic</span><span
																		id="cke_49_description" class="cke_button_label"
																		aria-hidden="false">Keyboard shortcut
																		Ctrl+I</span></a><a id="cke_50"
																	class="cke_button cke_button__underline cke_button_off"
																	href="javascript:void('Underline')"
																	title="Underline (Ctrl+U)" tabindex="-1"
																	hidefocus="true" role="button"
																	aria-labelledby="cke_50_label"
																	aria-describedby="cke_50_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(86,event);"
																	onfocus="return CKEDITOR.tools.callFunction(87,event);"
																	onclick="CKEDITOR.tools.callFunction(88,this);return false;"><span
																		class="cke_button_icon cke_button__underline_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -144px;background-size:auto;">&nbsp;</span><span
																		id="cke_50_label"
																		class="cke_button_label cke_button__underline_label"
																		aria-hidden="false">Underline</span><span
																		id="cke_50_description" class="cke_button_label"
																		aria-hidden="false">Keyboard shortcut
																		Ctrl+U</span></a><a id="cke_51"
																	class="cke_button cke_button__strike cke_button_off"
																	href="javascript:void('Strikethrough')"
																	title="Strikethrough" tabindex="-1" hidefocus="true"
																	role="button" aria-labelledby="cke_51_label"
																	aria-describedby="cke_51_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(89,event);"
																	onfocus="return CKEDITOR.tools.callFunction(90,event);"
																	onclick="CKEDITOR.tools.callFunction(91,this);return false;"><span
																		class="cke_button_icon cke_button__strike_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -72px;background-size:auto;">&nbsp;</span><span
																		id="cke_51_label"
																		class="cke_button_label cke_button__strike_label"
																		aria-hidden="false">Strikethrough</span><span
																		id="cke_51_description" class="cke_button_label"
																		aria-hidden="false"></span></a><a id="cke_52"
																	class="cke_button cke_button__subscript cke_button_off"
																	href="javascript:void('Subscript')"
																	title="Subscript" tabindex="-1" hidefocus="true"
																	role="button" aria-labelledby="cke_52_label"
																	aria-describedby="cke_52_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(92,event);"
																	onfocus="return CKEDITOR.tools.callFunction(93,event);"
																	onclick="CKEDITOR.tools.callFunction(94,this);return false;"><span
																		class="cke_button_icon cke_button__subscript_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -96px;background-size:auto;">&nbsp;</span><span
																		id="cke_52_label"
																		class="cke_button_label cke_button__subscript_label"
																		aria-hidden="false">Subscript</span><span
																		id="cke_52_description" class="cke_button_label"
																		aria-hidden="false"></span></a><a id="cke_53"
																	class="cke_button cke_button__superscript cke_button_off"
																	href="javascript:void('Superscript')"
																	title="Superscript" tabindex="-1" hidefocus="true"
																	role="button" aria-labelledby="cke_53_label"
																	aria-describedby="cke_53_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(95,event);"
																	onfocus="return CKEDITOR.tools.callFunction(96,event);"
																	onclick="CKEDITOR.tools.callFunction(97,this);return false;"><span
																		class="cke_button_icon cke_button__superscript_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -120px;background-size:auto;">&nbsp;</span><span
																		id="cke_53_label"
																		class="cke_button_label cke_button__superscript_label"
																		aria-hidden="false">Superscript</span><span
																		id="cke_53_description" class="cke_button_label"
																		aria-hidden="false"></span></a><span
																	class="cke_toolbar_separator"
																	role="separator"></span><a id="cke_54"
																	class="cke_button cke_button__copyformatting cke_button_off"
																	href="javascript:void('Copy Formatting')"
																	title="Copy Formatting (Ctrl+Shift+C)" tabindex="-1"
																	hidefocus="true" role="button"
																	aria-labelledby="cke_54_label"
																	aria-describedby="cke_54_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(98,event);"
																	onfocus="return CKEDITOR.tools.callFunction(99,event);"
																	onclick="CKEDITOR.tools.callFunction(100,this);return false;"><span
																		class="cke_button_icon cke_button__copyformatting_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -480px;background-size:auto;">&nbsp;</span><span
																		id="cke_54_label"
																		class="cke_button_label cke_button__copyformatting_label"
																		aria-hidden="false">Copy Formatting</span><span
																		id="cke_54_description" class="cke_button_label"
																		aria-hidden="false">Keyboard shortcut
																		Ctrl+Shift+C</span></a><a id="cke_55"
																	class="cke_button cke_button__removeformat cke_button_off"
																	href="javascript:void('Remove Format')"
																	title="Remove Format" tabindex="-1" hidefocus="true"
																	role="button" aria-labelledby="cke_55_label"
																	aria-describedby="cke_55_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(101,event);"
																	onfocus="return CKEDITOR.tools.callFunction(102,event);"
																	onclick="CKEDITOR.tools.callFunction(103,this);return false;"><span
																		class="cke_button_icon cke_button__removeformat_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -1704px;background-size:auto;">&nbsp;</span><span
																		id="cke_55_label"
																		class="cke_button_label cke_button__removeformat_label"
																		aria-hidden="false">Remove Format</span><span
																		id="cke_55_description" class="cke_button_label"
																		aria-hidden="false"></span></a></span><span
																class="cke_toolbar_end"></span></span><span id="cke_56"
															class="cke_toolbar" aria-labelledby="cke_56_label"
															role="toolbar"><span id="cke_56_label"
																class="cke_voice_label">Paragraph</span><span
																class="cke_toolbar_start"></span><span
																class="cke_toolgroup" role="presentation"><a id="cke_57"
																	class="cke_button cke_button__numberedlist cke_button_off"
																	href="javascript:void('Insert/Remove Numbered List')"
																	title="Insert/Remove Numbered List" tabindex="-1"
																	hidefocus="true" role="button"
																	aria-labelledby="cke_57_label"
																	aria-describedby="cke_57_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(104,event);"
																	onfocus="return CKEDITOR.tools.callFunction(105,event);"
																	onclick="CKEDITOR.tools.callFunction(106,this);return false;"><span
																		class="cke_button_icon cke_button__numberedlist_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -1392px;background-size:auto;">&nbsp;</span><span
																		id="cke_57_label"
																		class="cke_button_label cke_button__numberedlist_label"
																		aria-hidden="false">Insert/Remove Numbered
																		List</span><span id="cke_57_description"
																		class="cke_button_label"
																		aria-hidden="false"></span></a><a id="cke_58"
																	class="cke_button cke_button__bulletedlist cke_button_off"
																	href="javascript:void('Insert/Remove Bulleted List')"
																	title="Insert/Remove Bulleted List" tabindex="-1"
																	hidefocus="true" role="button"
																	aria-labelledby="cke_58_label"
																	aria-describedby="cke_58_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(107,event);"
																	onfocus="return CKEDITOR.tools.callFunction(108,event);"
																	onclick="CKEDITOR.tools.callFunction(109,this);return false;"><span
																		class="cke_button_icon cke_button__bulletedlist_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -1344px;background-size:auto;">&nbsp;</span><span
																		id="cke_58_label"
																		class="cke_button_label cke_button__bulletedlist_label"
																		aria-hidden="false">Insert/Remove Bulleted
																		List</span><span id="cke_58_description"
																		class="cke_button_label"
																		aria-hidden="false"></span></a><span
																	class="cke_toolbar_separator"
																	role="separator"></span><a id="cke_59"
																	class="cke_button cke_button__outdent cke_button_disabled "
																	href="javascript:void('Decrease Indent')"
																	title="Decrease Indent" tabindex="-1"
																	hidefocus="true" role="button"
																	aria-labelledby="cke_59_label"
																	aria-describedby="cke_59_description"
																	aria-haspopup="false" aria-disabled="true"
																	onkeydown="return CKEDITOR.tools.callFunction(110,event);"
																	onfocus="return CKEDITOR.tools.callFunction(111,event);"
																	onclick="CKEDITOR.tools.callFunction(112,this);return false;"><span
																		class="cke_button_icon cke_button__outdent_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -1056px;background-size:auto;">&nbsp;</span><span
																		id="cke_59_label"
																		class="cke_button_label cke_button__outdent_label"
																		aria-hidden="false">Decrease Indent</span><span
																		id="cke_59_description" class="cke_button_label"
																		aria-hidden="false"></span></a><a id="cke_60"
																	class="cke_button cke_button__indent cke_button_off"
																	href="javascript:void('Increase Indent')"
																	title="Increase Indent" tabindex="-1"
																	hidefocus="true" role="button"
																	aria-labelledby="cke_60_label"
																	aria-describedby="cke_60_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(113,event);"
																	onfocus="return CKEDITOR.tools.callFunction(114,event);"
																	onclick="CKEDITOR.tools.callFunction(115,this);return false;"><span
																		class="cke_button_icon cke_button__indent_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -1008px;background-size:auto;">&nbsp;</span><span
																		id="cke_60_label"
																		class="cke_button_label cke_button__indent_label"
																		aria-hidden="false">Increase Indent</span><span
																		id="cke_60_description" class="cke_button_label"
																		aria-hidden="false"></span></a><span
																	class="cke_toolbar_separator"
																	role="separator"></span><a id="cke_61"
																	class="cke_button cke_button__blockquote cke_button_off"
																	href="javascript:void('Block Quote')"
																	title="Block Quote" tabindex="-1" hidefocus="true"
																	role="button" aria-labelledby="cke_61_label"
																	aria-describedby="cke_61_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(116,event);"
																	onfocus="return CKEDITOR.tools.callFunction(117,event);"
																	onclick="CKEDITOR.tools.callFunction(118,this);return false;"><span
																		class="cke_button_icon cke_button__blockquote_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -216px;background-size:auto;">&nbsp;</span><span
																		id="cke_61_label"
																		class="cke_button_label cke_button__blockquote_label"
																		aria-hidden="false">Block Quote</span><span
																		id="cke_61_description" class="cke_button_label"
																		aria-hidden="false"></span></a><a id="cke_62"
																	class="cke_button cke_button__creatediv cke_button_off"
																	href="javascript:void('Create Div Container')"
																	title="Create Div Container" tabindex="-1"
																	hidefocus="true" role="button"
																	aria-labelledby="cke_62_label"
																	aria-describedby="cke_62_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(119,event);"
																	onfocus="return CKEDITOR.tools.callFunction(120,event);"
																	onclick="CKEDITOR.tools.callFunction(121,this);return false;"><span
																		class="cke_button_icon cke_button__creatediv_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -504px;background-size:auto;">&nbsp;</span><span
																		id="cke_62_label"
																		class="cke_button_label cke_button__creatediv_label"
																		aria-hidden="false">Create Div
																		Container</span><span id="cke_62_description"
																		class="cke_button_label"
																		aria-hidden="false"></span></a><span
																	class="cke_toolbar_separator"
																	role="separator"></span><a id="cke_63"
																	class="cke_button cke_button__justifyleft cke_button_off"
																	href="javascript:void('Align Left')"
																	title="Align Left" tabindex="-1" hidefocus="true"
																	role="button" aria-labelledby="cke_63_label"
																	aria-describedby="cke_63_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(122,event);"
																	onfocus="return CKEDITOR.tools.callFunction(123,event);"
																	onclick="CKEDITOR.tools.callFunction(124,this);return false;"><span
																		class="cke_button_icon cke_button__justifyleft_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -1152px;background-size:auto;">&nbsp;</span><span
																		id="cke_63_label"
																		class="cke_button_label cke_button__justifyleft_label"
																		aria-hidden="false">Align Left</span><span
																		id="cke_63_description" class="cke_button_label"
																		aria-hidden="false"></span></a><a id="cke_64"
																	class="cke_button cke_button__justifycenter cke_button_off"
																	href="javascript:void('Center')" title="Center"
																	tabindex="-1" hidefocus="true" role="button"
																	aria-labelledby="cke_64_label"
																	aria-describedby="cke_64_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(125,event);"
																	onfocus="return CKEDITOR.tools.callFunction(126,event);"
																	onclick="CKEDITOR.tools.callFunction(127,this);return false;"><span
																		class="cke_button_icon cke_button__justifycenter_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -1128px;background-size:auto;">&nbsp;</span><span
																		id="cke_64_label"
																		class="cke_button_label cke_button__justifycenter_label"
																		aria-hidden="false">Center</span><span
																		id="cke_64_description" class="cke_button_label"
																		aria-hidden="false"></span></a><a id="cke_65"
																	class="cke_button cke_button__justifyright cke_button_off"
																	href="javascript:void('Align Right')"
																	title="Align Right" tabindex="-1" hidefocus="true"
																	role="button" aria-labelledby="cke_65_label"
																	aria-describedby="cke_65_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(128,event);"
																	onfocus="return CKEDITOR.tools.callFunction(129,event);"
																	onclick="CKEDITOR.tools.callFunction(130,this);return false;"><span
																		class="cke_button_icon cke_button__justifyright_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -1176px;background-size:auto;">&nbsp;</span><span
																		id="cke_65_label"
																		class="cke_button_label cke_button__justifyright_label"
																		aria-hidden="false">Align Right</span><span
																		id="cke_65_description" class="cke_button_label"
																		aria-hidden="false"></span></a><a id="cke_66"
																	class="cke_button cke_button__justifyblock cke_button_off"
																	href="javascript:void('Justify')" title="Justify"
																	tabindex="-1" hidefocus="true" role="button"
																	aria-labelledby="cke_66_label"
																	aria-describedby="cke_66_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(131,event);"
																	onfocus="return CKEDITOR.tools.callFunction(132,event);"
																	onclick="CKEDITOR.tools.callFunction(133,this);return false;"><span
																		class="cke_button_icon cke_button__justifyblock_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -1104px;background-size:auto;">&nbsp;</span><span
																		id="cke_66_label"
																		class="cke_button_label cke_button__justifyblock_label"
																		aria-hidden="false">Justify</span><span
																		id="cke_66_description" class="cke_button_label"
																		aria-hidden="false"></span></a><span
																	class="cke_toolbar_separator"
																	role="separator"></span><a id="cke_67"
																	class="cke_button cke_button__bidiltr cke_button_off"
																	href="javascript:void('Text direction from left to right')"
																	title="Text direction from left to right"
																	tabindex="-1" hidefocus="true" role="button"
																	aria-labelledby="cke_67_label"
																	aria-describedby="cke_67_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(134,event);"
																	onfocus="return CKEDITOR.tools.callFunction(135,event);"
																	onclick="CKEDITOR.tools.callFunction(136,this);return false;"><span
																		class="cke_button_icon cke_button__bidiltr_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -168px;background-size:auto;">&nbsp;</span><span
																		id="cke_67_label"
																		class="cke_button_label cke_button__bidiltr_label"
																		aria-hidden="false">Text direction from left to
																		right</span><span id="cke_67_description"
																		class="cke_button_label"
																		aria-hidden="false"></span></a><a id="cke_68"
																	class="cke_button cke_button__bidirtl cke_button_off"
																	href="javascript:void('Text direction from right to left')"
																	title="Text direction from right to left"
																	tabindex="-1" hidefocus="true" role="button"
																	aria-labelledby="cke_68_label"
																	aria-describedby="cke_68_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(137,event);"
																	onfocus="return CKEDITOR.tools.callFunction(138,event);"
																	onclick="CKEDITOR.tools.callFunction(139,this);return false;"><span
																		class="cke_button_icon cke_button__bidirtl_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -192px;background-size:auto;">&nbsp;</span><span
																		id="cke_68_label"
																		class="cke_button_label cke_button__bidirtl_label"
																		aria-hidden="false">Text direction from right to
																		left</span><span id="cke_68_description"
																		class="cke_button_label"
																		aria-hidden="false"></span></a><a id="cke_69"
																	class="cke_button cke_button__language cke_button_off"
																	href="javascript:void('Set language')"
																	title="Set language" tabindex="-1" hidefocus="true"
																	role="button" aria-labelledby="cke_69_label"
																	aria-describedby="cke_69_description"
																	aria-haspopup="true"
																	onkeydown="return CKEDITOR.tools.callFunction(140,event);"
																	onfocus="return CKEDITOR.tools.callFunction(141,event);"
																	onclick="CKEDITOR.tools.callFunction(142,this);return false;"><span
																		class="cke_button_icon cke_button__language_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -1200px;background-size:auto;">&nbsp;</span><span
																		id="cke_69_label"
																		class="cke_button_label cke_button__language_label"
																		aria-hidden="false">Set language</span><span
																		id="cke_69_description" class="cke_button_label"
																		aria-hidden="false"></span><span
																		class="cke_button_arrow"></span></a></span><span
																class="cke_toolbar_end"></span></span><span id="cke_70"
															class="cke_toolbar" aria-labelledby="cke_70_label"
															role="toolbar"><span id="cke_70_label"
																class="cke_voice_label">Links</span><span
																class="cke_toolbar_start"></span><span
																class="cke_toolgroup" role="presentation"><a id="cke_71"
																	class="cke_button cke_button__link cke_button_off"
																	href="javascript:void('Link')" title="Link (Ctrl+L)"
																	tabindex="-1" hidefocus="true" role="button"
																	aria-labelledby="cke_71_label"
																	aria-describedby="cke_71_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(143,event);"
																	onfocus="return CKEDITOR.tools.callFunction(144,event);"
																	onclick="CKEDITOR.tools.callFunction(145,this);return false;"><span
																		class="cke_button_icon cke_button__link_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -1272px;background-size:auto;">&nbsp;</span><span
																		id="cke_71_label"
																		class="cke_button_label cke_button__link_label"
																		aria-hidden="false">Link</span><span
																		id="cke_71_description" class="cke_button_label"
																		aria-hidden="false">Keyboard shortcut
																		Ctrl+L</span></a><a id="cke_72"
																	class="cke_button cke_button__unlink cke_button_disabled "
																	href="javascript:void('Unlink')" title="Unlink"
																	tabindex="-1" hidefocus="true" role="button"
																	aria-labelledby="cke_72_label"
																	aria-describedby="cke_72_description"
																	aria-haspopup="false" aria-disabled="true"
																	onkeydown="return CKEDITOR.tools.callFunction(146,event);"
																	onfocus="return CKEDITOR.tools.callFunction(147,event);"
																	onclick="CKEDITOR.tools.callFunction(148,this);return false;"><span
																		class="cke_button_icon cke_button__unlink_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -1296px;background-size:auto;">&nbsp;</span><span
																		id="cke_72_label"
																		class="cke_button_label cke_button__unlink_label"
																		aria-hidden="false">Unlink</span><span
																		id="cke_72_description" class="cke_button_label"
																		aria-hidden="false"></span></a><a id="cke_73"
																	class="cke_button cke_button__anchor cke_button_off"
																	href="javascript:void('Anchor')" title="Anchor"
																	tabindex="-1" hidefocus="true" role="button"
																	aria-labelledby="cke_73_label"
																	aria-describedby="cke_73_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(149,event);"
																	onfocus="return CKEDITOR.tools.callFunction(150,event);"
																	onclick="CKEDITOR.tools.callFunction(151,this);return false;"><span
																		class="cke_button_icon cke_button__anchor_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -1248px;background-size:auto;">&nbsp;</span><span
																		id="cke_73_label"
																		class="cke_button_label cke_button__anchor_label"
																		aria-hidden="false">Anchor</span><span
																		id="cke_73_description" class="cke_button_label"
																		aria-hidden="false"></span></a></span><span
																class="cke_toolbar_end"></span></span><span id="cke_74"
															class="cke_toolbar cke_toolbar_last"
															aria-labelledby="cke_74_label" role="toolbar"><span
																id="cke_74_label"
																class="cke_voice_label">Insert</span><span
																class="cke_toolbar_start"></span><span
																class="cke_toolgroup" role="presentation"><a id="cke_75"
																	class="cke_button cke_button__image cke_button_off"
																	href="javascript:void('Image')" title="Image"
																	tabindex="-1" hidefocus="true" role="button"
																	aria-labelledby="cke_75_label"
																	aria-describedby="cke_75_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(152,event);"
																	onfocus="return CKEDITOR.tools.callFunction(153,event);"
																	onclick="CKEDITOR.tools.callFunction(154,this);return false;"><span
																		class="cke_button_icon cke_button__image_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -960px;background-size:auto;">&nbsp;</span><span
																		id="cke_75_label"
																		class="cke_button_label cke_button__image_label"
																		aria-hidden="false">Image</span><span
																		id="cke_75_description" class="cke_button_label"
																		aria-hidden="false"></span></a><a id="cke_76"
																	class="cke_button cke_button__flash cke_button_off"
																	href="javascript:void('Flash')" title="Flash"
																	tabindex="-1" hidefocus="true" role="button"
																	aria-labelledby="cke_76_label"
																	aria-describedby="cke_76_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(155,event);"
																	onfocus="return CKEDITOR.tools.callFunction(156,event);"
																	onclick="CKEDITOR.tools.callFunction(157,this);return false;"><span
																		class="cke_button_icon cke_button__flash_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -600px;background-size:auto;">&nbsp;</span><span
																		id="cke_76_label"
																		class="cke_button_label cke_button__flash_label"
																		aria-hidden="false">Flash</span><span
																		id="cke_76_description" class="cke_button_label"
																		aria-hidden="false"></span></a><a id="cke_77"
																	class="cke_button cke_button__table cke_button_off"
																	href="javascript:void('Table')" title="Table"
																	tabindex="-1" hidefocus="true" role="button"
																	aria-labelledby="cke_77_label"
																	aria-describedby="cke_77_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(158,event);"
																	onfocus="return CKEDITOR.tools.callFunction(159,event);"
																	onclick="CKEDITOR.tools.callFunction(160,this);return false;"><span
																		class="cke_button_icon cke_button__table_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -1920px;background-size:auto;">&nbsp;</span><span
																		id="cke_77_label"
																		class="cke_button_label cke_button__table_label"
																		aria-hidden="false">Table</span><span
																		id="cke_77_description" class="cke_button_label"
																		aria-hidden="false"></span></a><a id="cke_78"
																	class="cke_button cke_button__horizontalrule cke_button_off"
																	href="javascript:void('Insert Horizontal Line')"
																	title="Insert Horizontal Line" tabindex="-1"
																	hidefocus="true" role="button"
																	aria-labelledby="cke_78_label"
																	aria-describedby="cke_78_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(161,event);"
																	onfocus="return CKEDITOR.tools.callFunction(162,event);"
																	onclick="CKEDITOR.tools.callFunction(163,this);return false;"><span
																		class="cke_button_icon cke_button__horizontalrule_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -912px;background-size:auto;">&nbsp;</span><span
																		id="cke_78_label"
																		class="cke_button_label cke_button__horizontalrule_label"
																		aria-hidden="false">Insert Horizontal
																		Line</span><span id="cke_78_description"
																		class="cke_button_label"
																		aria-hidden="false"></span></a><a id="cke_79"
																	class="cke_button cke_button__smiley cke_button_off"
																	href="javascript:void('Smiley')" title="Smiley"
																	tabindex="-1" hidefocus="true" role="button"
																	aria-labelledby="cke_79_label"
																	aria-describedby="cke_79_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(164,event);"
																	onfocus="return CKEDITOR.tools.callFunction(165,event);"
																	onclick="CKEDITOR.tools.callFunction(166,this);return false;"><span
																		class="cke_button_icon cke_button__smiley_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -1080px;background-size:auto;">&nbsp;</span><span
																		id="cke_79_label"
																		class="cke_button_label cke_button__smiley_label"
																		aria-hidden="false">Smiley</span><span
																		id="cke_79_description" class="cke_button_label"
																		aria-hidden="false"></span></a><a id="cke_80"
																	class="cke_button cke_button__specialchar cke_button_off"
																	href="javascript:void('Insert Special Character')"
																	title="Insert Special Character" tabindex="-1"
																	hidefocus="true" role="button"
																	aria-labelledby="cke_80_label"
																	aria-describedby="cke_80_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(167,event);"
																	onfocus="return CKEDITOR.tools.callFunction(168,event);"
																	onclick="CKEDITOR.tools.callFunction(169,this);return false;"><span
																		class="cke_button_icon cke_button__specialchar_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -1872px;background-size:auto;">&nbsp;</span><span
																		id="cke_80_label"
																		class="cke_button_label cke_button__specialchar_label"
																		aria-hidden="false">Insert Special
																		Character</span><span id="cke_80_description"
																		class="cke_button_label"
																		aria-hidden="false"></span></a><a id="cke_81"
																	class="cke_button cke_button__pagebreak cke_button_off"
																	href="javascript:void('Insert Page Break for Printing')"
																	title="Insert Page Break for Printing" tabindex="-1"
																	hidefocus="true" role="button"
																	aria-labelledby="cke_81_label"
																	aria-describedby="cke_81_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(170,event);"
																	onfocus="return CKEDITOR.tools.callFunction(171,event);"
																	onclick="CKEDITOR.tools.callFunction(172,this);return false;"><span
																		class="cke_button_icon cke_button__pagebreak_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -1512px;background-size:auto;">&nbsp;</span><span
																		id="cke_81_label"
																		class="cke_button_label cke_button__pagebreak_label"
																		aria-hidden="false">Insert Page Break for
																		Printing</span><span id="cke_81_description"
																		class="cke_button_label"
																		aria-hidden="false"></span></a><a id="cke_82"
																	class="cke_button cke_button__iframe cke_button_off"
																	href="javascript:void('IFrame')" title="IFrame"
																	tabindex="-1" hidefocus="true" role="button"
																	aria-labelledby="cke_82_label"
																	aria-describedby="cke_82_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(173,event);"
																	onfocus="return CKEDITOR.tools.callFunction(174,event);"
																	onclick="CKEDITOR.tools.callFunction(175,this);return false;"><span
																		class="cke_button_icon cke_button__iframe_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -936px;background-size:auto;">&nbsp;</span><span
																		id="cke_82_label"
																		class="cke_button_label cke_button__iframe_label"
																		aria-hidden="false">IFrame</span><span
																		id="cke_82_description" class="cke_button_label"
																		aria-hidden="false"></span></a></span><span
																class="cke_toolbar_end"></span></span><span
															class="cke_toolbar_break"></span><span id="cke_83"
															class="cke_toolbar" aria-labelledby="cke_83_label"
															role="toolbar"><span id="cke_83_label"
																class="cke_voice_label">Styles</span><span
																class="cke_toolbar_start"></span><span id="cke_13"
																class="cke_combo cke_combo__styles cke_combo_off"
																role="presentation"><span id="cke_13_label"
																	class="cke_combo_label">Styles</span><a
																	class="cke_combo_button" title="Formatting Styles"
																	tabindex="-1"
																	href="javascript:void('Formatting Styles')"
																	hidefocus="true" role="button"
																	aria-labelledby="cke_13_label" aria-haspopup="true"
																	onkeydown="return CKEDITOR.tools.callFunction(177,event,this);"
																	onfocus="return CKEDITOR.tools.callFunction(178,event);"
																	onclick="CKEDITOR.tools.callFunction(176,this);return false;"><span
																		id="cke_13_text"
																		class="cke_combo_text cke_combo_inlinelabel">Styles</span><span
																		class="cke_combo_open"><span
																			class="cke_combo_arrow"></span></span></a></span><span
																id="cke_14"
																class="cke_combo cke_combo__format cke_combo_off"
																role="presentation"><span id="cke_14_label"
																	class="cke_combo_label">Format</span><a
																	class="cke_combo_button" title="Paragraph Format"
																	tabindex="-1"
																	href="javascript:void('Paragraph Format')"
																	hidefocus="true" role="button"
																	aria-labelledby="cke_14_label" aria-haspopup="true"
																	onkeydown="return CKEDITOR.tools.callFunction(180,event,this);"
																	onfocus="return CKEDITOR.tools.callFunction(181,event);"
																	onclick="CKEDITOR.tools.callFunction(179,this);return false;"><span
																		id="cke_14_text"
																		class="cke_combo_text cke_combo_inlinelabel">Format</span><span
																		class="cke_combo_open"><span
																			class="cke_combo_arrow"></span></span></a></span><span
																id="cke_15"
																class="cke_combo cke_combo__font cke_combo_off"
																role="presentation"><span id="cke_15_label"
																	class="cke_combo_label">Font</span><a
																	class="cke_combo_button" title="Font Name"
																	tabindex="-1" href="javascript:void('Font Name')"
																	hidefocus="true" role="button"
																	aria-labelledby="cke_15_label" aria-haspopup="true"
																	onkeydown="return CKEDITOR.tools.callFunction(183,event,this);"
																	onfocus="return CKEDITOR.tools.callFunction(184,event);"
																	onclick="CKEDITOR.tools.callFunction(182,this);return false;"><span
																		id="cke_15_text"
																		class="cke_combo_text cke_combo_inlinelabel">Font</span><span
																		class="cke_combo_open"><span
																			class="cke_combo_arrow"></span></span></a></span><span
																id="cke_16"
																class="cke_combo cke_combo__fontsize cke_combo_off"
																role="presentation"><span id="cke_16_label"
																	class="cke_combo_label">Size</span><a
																	class="cke_combo_button" title="Font Size"
																	tabindex="-1" href="javascript:void('Font Size')"
																	hidefocus="true" role="button"
																	aria-labelledby="cke_16_label" aria-haspopup="true"
																	onkeydown="return CKEDITOR.tools.callFunction(186,event,this);"
																	onfocus="return CKEDITOR.tools.callFunction(187,event);"
																	onclick="CKEDITOR.tools.callFunction(185,this);return false;"><span
																		id="cke_16_text"
																		class="cke_combo_text cke_combo_inlinelabel">Size</span><span
																		class="cke_combo_open"><span
																			class="cke_combo_arrow"></span></span></a></span><span
																class="cke_toolbar_end"></span></span><span id="cke_84"
															class="cke_toolbar" aria-labelledby="cke_84_label"
															role="toolbar"><span id="cke_84_label"
																class="cke_voice_label">Colors</span><span
																class="cke_toolbar_start"></span><span
																class="cke_toolgroup" role="presentation"><a id="cke_85"
																	class="cke_button cke_button__textcolor cke_button_off"
																	href="javascript:void('Text Color')"
																	title="Text Color" tabindex="-1" hidefocus="true"
																	role="button" aria-labelledby="cke_85_label"
																	aria-describedby="cke_85_description"
																	aria-haspopup="true"
																	onkeydown="return CKEDITOR.tools.callFunction(188,event);"
																	onfocus="return CKEDITOR.tools.callFunction(189,event);"
																	onclick="CKEDITOR.tools.callFunction(190,this);return false;"><span
																		class="cke_button_icon cke_button__textcolor_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -408px;background-size:auto;">&nbsp;</span><span
																		id="cke_85_label"
																		class="cke_button_label cke_button__textcolor_label"
																		aria-hidden="false">Text Color</span><span
																		id="cke_85_description" class="cke_button_label"
																		aria-hidden="false"></span><span
																		class="cke_button_arrow"></span></a><a
																	id="cke_86"
																	class="cke_button cke_button__bgcolor cke_button_off"
																	href="javascript:void('Background Color')"
																	title="Background Color" tabindex="-1"
																	hidefocus="true" role="button"
																	aria-labelledby="cke_86_label"
																	aria-describedby="cke_86_description"
																	aria-haspopup="true"
																	onkeydown="return CKEDITOR.tools.callFunction(191,event);"
																	onfocus="return CKEDITOR.tools.callFunction(192,event);"
																	onclick="CKEDITOR.tools.callFunction(193,this);return false;"><span
																		class="cke_button_icon cke_button__bgcolor_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -384px;background-size:auto;">&nbsp;</span><span
																		id="cke_86_label"
																		class="cke_button_label cke_button__bgcolor_label"
																		aria-hidden="false">Background Color</span><span
																		id="cke_86_description" class="cke_button_label"
																		aria-hidden="false"></span><span
																		class="cke_button_arrow"></span></a></span><span
																class="cke_toolbar_end"></span></span><span id="cke_87"
															class="cke_toolbar" aria-labelledby="cke_87_label"
															role="toolbar"><span id="cke_87_label"
																class="cke_voice_label">Tools</span><span
																class="cke_toolbar_start"></span><span
																class="cke_toolgroup" role="presentation"><a id="cke_88"
																	class="cke_button cke_button__maximize cke_button_off"
																	href="javascript:void('Maximize')" title="Maximize"
																	tabindex="-1" hidefocus="true" role="button"
																	aria-labelledby="cke_88_label"
																	aria-describedby="cke_88_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(194,event);"
																	onfocus="return CKEDITOR.tools.callFunction(195,event);"
																	onclick="CKEDITOR.tools.callFunction(196,this);return false;"><span
																		class="cke_button_icon cke_button__maximize_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -1416px;background-size:auto;">&nbsp;</span><span
																		id="cke_88_label"
																		class="cke_button_label cke_button__maximize_label"
																		aria-hidden="false">Maximize</span><span
																		id="cke_88_description" class="cke_button_label"
																		aria-hidden="false"></span></a><a id="cke_89"
																	class="cke_button cke_button__showblocks cke_button_off"
																	href="javascript:void('Show Blocks')"
																	title="Show Blocks" tabindex="-1" hidefocus="true"
																	role="button" aria-labelledby="cke_89_label"
																	aria-describedby="cke_89_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(197,event);"
																	onfocus="return CKEDITOR.tools.callFunction(198,event);"
																	onclick="CKEDITOR.tools.callFunction(199,this);return false;"><span
																		class="cke_button_icon cke_button__showblocks_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 -1800px;background-size:auto;">&nbsp;</span><span
																		id="cke_89_label"
																		class="cke_button_label cke_button__showblocks_label"
																		aria-hidden="false">Show Blocks</span><span
																		id="cke_89_description" class="cke_button_label"
																		aria-hidden="false"></span></a></span><span
																class="cke_toolbar_end"></span></span><span id="cke_90"
															class="cke_toolbar cke_toolbar_last"
															aria-labelledby="cke_90_label" role="toolbar"><span
																id="cke_90_label"
																class="cke_voice_label">about</span><span
																class="cke_toolbar_start"></span><span
																class="cke_toolgroup" role="presentation"><a id="cke_91"
																	class="cke_button cke_button__about cke_button_off"
																	href="javascript:void('About CKEditor 4')"
																	title="About CKEditor 4" tabindex="-1"
																	hidefocus="true" role="button"
																	aria-labelledby="cke_91_label"
																	aria-describedby="cke_91_description"
																	aria-haspopup="false"
																	onkeydown="return CKEDITOR.tools.callFunction(200,event);"
																	onfocus="return CKEDITOR.tools.callFunction(201,event);"
																	onclick="CKEDITOR.tools.callFunction(202,this);return false;"><span
																		class="cke_button_icon cke_button__about_icon"
																		style="background-image:url('https://crmx-admin-template.multipurposethemes.com/bs5/assets/vendor_components/ckeditor/plugins/icons.png?t=I2QI');background-position:0 0px;background-size:auto;">&nbsp;</span><span
																		id="cke_91_label"
																		class="cke_button_label cke_button__about_label"
																		aria-hidden="false">About CKEditor 4</span><span
																		id="cke_91_description" class="cke_button_label"
																		aria-hidden="false"></span></a></span><span
																class="cke_toolbar_end"></span></span></span></span>
												<div id="cke_1_contents" class="cke_contents cke_reset"
													role="presentation" style="height: 200px;"><span id="cke_96"
														class="cke_voice_label">Press ALT 0 for help</span><iframe
														src="" frameborder="0" class="cke_wysiwyg_frame cke_reset"
														title="Rich Text Editor, editor1" aria-describedby="cke_96"
														tabindex="0" allowtransparency="true"
														style="width: 100%; height: 100%;"></iframe></div><span
													id="cke_1_bottom" class="cke_bottom cke_reset_all"
													role="presentation" style="user-select: none;"><span
														id="cke_1_resizer"
														class="cke_resizer cke_resizer_vertical cke_resizer_ltr"
														title="Resize"
														onmousedown="CKEDITOR.tools.callFunction(0, event)">◢</span><span
														id="cke_1_path_label" class="cke_voice_label">Elements
														path</span><span id="cke_1_path" class="cke_path" role="group"
														aria-labelledby="cke_1_path_label"><span
															class="cke_path_empty">&nbsp;</span></span></span>
											</div>
										</div>
									</form>
								</div>
							</div>
							<!-- /.box -->

							<div class="box">
								<div class="box-header">
									<h4 class="box-title">
										Bootstrap WYSIHTML5<br />
										<small>Bootstrap html5 editor</small>
									</h4>
								</div>
								<!-- /.box-header -->
								<div class="box-body">
									<form>
										<textarea class="textarea" placeholder="Place some text here" style="
                          width: 100%;
                          height: 200px;
                          font-size: 14px;
                          line-height: 18px;
                          border: 1px solid #dddddd;
                          padding: 10px;
                        "></textarea>
									</form>
								</div>
							</div>
							<!-- /.box -->
						</div>
						<!-- /.col-->
					</div>
					<!-- ./row -->
				</section>
				<!-- /.content -->
			</div>
		</div>
  <!-- /.content-wrapper -->

  @include('admin.layouts.partials.footer')

  <!-- Control Sidebar -->
  <!-- /.control-sidebar -->

  <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- Vendor JS -->
		<script src="{{ asset('admin/main/js/vendors.min.js') }}"></script>
		<script src="{{ asset('admin/main/js/pages/chat-popup.js') }}"></script>
		<script src="{{ asset('admin/assets/icons/feather-icons/feather.min.js') }}"></script>
		<script src="{{ asset('admin/assets/vendor_components/apexcharts-bundle/irregular-data-series.js') }}"></script>
		<script src="{{ asset('admin/assets/vendor_components/apexcharts-bundle/dist/apexcharts.js') }}"></script>
		<script src="{{ asset('admin/assets/vendor_components/zingchart_branded_version/zingchart.min.js') }}"></script>
		<script src="https://www.amcharts.com/lib/4/core.js"></script>
		<script src="https://www.amcharts.com/lib/4/maps.js"></script>
		<script src="https://www.amcharts.com/lib/4/geodata/worldLow.js"></script>
		<script src="https://www.amcharts.com/lib/4/themes/dataviz.js"></script>
		<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>

		<!-- CrmX Admin App -->
		<script src="{{ asset('admin/main/js/template.js') }}"></script>
		<script src="{{ asset('admin/main/js/demo.js') }}"></script>
		<script src="{{ asset('admin/main/js/pages/dashboard.js') }}"></script>


</body>
</html>
