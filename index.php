<?php

require_once('include/Mustache.php');

class BugSubmitPage extends Mustache
{
	protected $_template = ''; // Content Template
	
	public function render()
	{
		return parent::render(file_get_contents('templates/template.mustache'));
	}
	
	/**
	 * Generate the slides
	 */
	
	protected function slides()
	{
		return array(
			array(
				'id' => 'introduction',
				'title' => 'Introduction',
				'buttons' => array(
								'next' => 'scrollToId(\'slide_search\')'
							),
				'content' => '<noscript>
						<div class="noscript">
							You do not appear to have Javascript enabled!
							You need to enable it for this form to work.
							For help on how to enable Javascript, <a href="http://www.google.com/support/bin/answer.py?answer=23852" target="_blank">see here.</a>
						</div>
					</noscript>
					<p>
						Thank you for showing interest in filing a bug report!
						An informative report will help the developers fix your bug quickly.
					</p>
					<p>
						<em>Please Note:</em> If you are having more than one problem, please fill
						this out separately for each one, as this makes life much easier for the developers.
					</p>
					<p>
						When you\'re ready to continue, click the \'Next\' button in the lower-right.
					</p>'
			),
			array(
				'id' => 'search',
				'title' => 'Search for Similar Bugs',
				'buttons' => array(
								'previous' => true,
								'next' => 'scrollToId(\'slide_problemtype\')'
							),
				'content' => '<div id="search_before_div">
						<p>
							Before you file a new bug, please search the bug reports.
							Someone else may have already found your bug - if you can add extra
							information to that report, it is more helpful to the developers than
							opening-up a duplicate bug.
						</p>
						<p>
							Just enter some key words reated to your problem into the box below and
							click \'Search\'. Then see if any of the bugs listed look like yours.
						</p>
						<form action="https://bugs.freedesktop.org/buglist.cgi" method="get" target="search_frame"
							onsubmit="javascript: return checkSearchForm(this);">
							<span id="search_alert" class="alert" style="float:right;">
								Please enter something to search for!</span>
							<input type="hidden" name="query_format" value="specific"/>
							<input type="hidden" name="order" value="relevance desc"/>
							<input type="hidden" name="bug_status" value="__open__"/>
							<input type="hidden" name="product" value="LibreOffice"/>
							<label for="bugsearch_input">Search for bugs:</label>
							<input type="text" name="content" id="bugsearch_input"/>
							<input type="submit" value="Search"/>
						</form>
						<p style="text-align: center;">
							<img id="search_loading_image" src="images/ajax-loader.gif" alt="Loading bugs..." style="display: none;"/>
						</p>
						
					</div>
					
					<div id="search_after_div" style="display: none;">
						<button style="top: 5px; position: absolute; right: 5px;" type="button" onclick="javascript:hideSearchDiv();">Close</button>
						<iframe id="search_frame" name="search_frame" style="width: 100%; height: 350px;"></iframe>
						<p>
							If you find that your bug has already been reported, please add any extra
							information you have to the existing report, rather than creating a new one.
						</p>
					</div>'
			),
			array(
				'id' => 'problemtype',
				'title' => 'File a New Bug',
				'buttons' => array(
								'previous' => true,
								'next' => 'scrollToIdFromValue(\'slide_problemtype\', \'problemtype\')'
							),
				'content' => '<p>
						What kind of problem are you having? Please select one of the following:
					</p>
					<ul>
						<li>
							<input type="radio" name="problemtype" id="problemtype_crash" value="crash"/>
							<label for="problemtype_crash">LibreOffice crashes. (It quits or stops working
								without you telling it to, maybe with an error message)</label>
						</li>
						<li>
							<input type="radio" name="problemtype" id="problemtype_docload" value="docload"/>
							<label for="problemtype_docload">My document looks wrong when I load it.</label>
						</li>
						<li>
							<input type="radio" name="problemtype" id="problemtype_unreadable" value="unreadable"/>
							<label for="problemtype_unreadable">Other people cannot read my document.</label>
						</li>
						<li>
							<input type="radio" name="problemtype" id="problemtype_ui" value="ui"/>
							<label for="problemtype_ui">LibreOffice is hard to use.</label>
						</li>
						<li>
							<input type="radio" name="problemtype" id="problemtype_www" value="www"/>
							<label for="problemtype_www">There is a problem with the website.</label>
						</li>
					</ul>
					<div class="hide" id="slide_problemtype_novalue">
						Please select a choice before continuing!
					</div>'
			),
			array(
				'id' => 'problemtype_crash',
				'title' => 'LibreOffice Crashes!',
				'buttons' => array(
								'previous' => true,
								'next' => 'scrollToIdIfRadioSelected(\'slide_problemtype_crash_os\', \'crash_when_option\')'
							),
				'content' => '<h3>When does LibreOffice crash?</h3>
					<ul>
						<li>
							<input type="radio" name="crash_when_option" id="crash_when_onload" value="onload"
								onclick="javascript:showDivFromGroup(\'crash_when\', \'onload\'); hideHelp()"/>
							<label for="crash_when_onload">When I load or save a certain document.</label>
						</li>
						
						<li>
							<input type="radio" name="crash_when_option" id="crash_when_steps" value="steps"
								onclick="javascript:showDivFromGroup(\'crash_when\', \'steps\'); hideHelp()"/>
							<label for="crash_when_steps">When I perform a series of steps.</label>
						</li>
						
						<li>
							<input type="radio" name="crash_when_option" id="crash_when_random" value="random"
								onclick="javascript:showDivFromGroup(\'crash_when\', \'random\'); hideHelp()"/>
							<label for="crash_when_random">It seems to happen randomly.</label>
						</li>
					</ul>
					
					<div id="crash_when_container">
						<div id="crash_when_onload_div" class="hide">
							<p>Please make the document file as small as possible, then attach it.
								<a href="javascript:showHelp(\'binary_chop\')">Show help</a>
							</p>
							<p><em>Placeholder: Form input for document upload</em></p>
						</div>
						
						<div id="crash_when_steps_div" class="hide">
							<p class="question" id="crash_when_steps_document_container">
								Do you need to load a document to execute those steps?
								<input type="radio" name="crash_when_steps_document_option" id="crash_when_steps_document_option_yes" value="true"/>
								<label for="crash_when_steps_document_option_yes">Yes</label>
								<input type="radio" name="crash_when_steps_document_option" id="crash_when_steps_document_option_no" value="false"/>
								<label for="crash_when_steps_document_option_no">No</label>
							</p>
							
							<div id="crash_when_steps_document_div" class="hide">
								<p><em>Placeholder: If all documents, or one in particular? 
									If one, make smaller and attach.</em></p>
							</div>
							<p>
								Please describe the steps that cause the crash, in detail, below:
							</p>
							<textarea name="crash_steps" rows="5" cols="80" style="width: 100%; height:180px;"> </textarea>
						</div>
						
						<div id="crash_when_random_div" class="hide">
							<p>Unfortunately, in order to fix your bug, we would need more information
								about what causes it. Please try to narrow it down - if you are having
								trouble, try asking for help in the
								<a href="javascript:showHelp(\'irc\')">LibreOffice chatroom</a>.</p>
						</div>
					</div>
					
					<div class="hide" id="slide_problemtype_crash_novalue">
						Please select a choice before continuing!
					</div>'
			),
			array(
				'id' => 'problemtype_crash_os',
				'title' => 'Which operating systems have you found the crash on?',
				'buttons' => array(
								'previous' => true,
								'next' => 'alert(\'TODO: Next slide\')'
							),
				'content' => '<p>Please tick all that apply.</p>
					<ul>
						<li>
							<input type="checkbox" name="crash_os_option" id="crash_os_windows_option" onclick="javascript:showFromCheckbox(this, \'crash_os_windows_div\')"/>
							<label for="crash_os_windows_option">Microsoft Windows</label>
							<p id="crash_os_windows_div" class="hide">
								<a name="crash_os_windows_a"></a>
								<em>Placeholder: If an error message pops-up, please take a screenshot
									of it and attach it.</em>
								<span class="fileinput"><input type="file" name="screenshots[]"/></span>
							</p>
						</li>
						
						<li>
							<input type="checkbox" name="crash_os_option" id="crash_os_linux_option" onclick="javascript:showFromCheckbox(this, \'crash_os_linux_div\')"/>
							<label for="crash_os_linux_option">Linux</label>
							<p id="crash_os_linux_div" class="hide">
								<a name="crash_os_linux_a"></a>
								Please follow
								<a href="javascript:showHelp(\'linux_backtrace\')">these instructions</a>
								to get a backtrace for your crash and then attach it below: <br/>
								<span class="fileinput"><input type="file" name="linux_backtrace" id="linux_backtrace"/></span>
							</p>
						</li>
						
						<li>
							<input type="checkbox" name="crash_os_option" id="crash_os_mac_option" onclick="javascript:showFromCheckbox(this, \'crash_os_mac_div\')"/>
							<label for="crash_os_mac_option">Apple Mac OS X</label>
							<p id="crash_os_mac_div" class="hide">
								<a name="crash_os_mac_a"></a>
								<em>Placeholder: Instructions for Apple Mac OS X</em>
							</p>
						</li>
						
						<li>
							<input type="checkbox" name="crash_os_option" id="crash_os_other_option" onclick="javascript:showFromCheckbox(this, \'crash_os_other_div\')"/>
							<label for="crash_os_other_option">Another Operating System</label>
							<p id="crash_os_other_div" class="hide">
								<a name="crash_os_other_a"></a>
								If the bug happened on a different operating system to the ones listed
								above, please enter its name and version in the text box below: <br/>
								<input name="crash_os_name" id="crash_os_name" type="text" />
							</p>
						</li>
					</ul>
					
					<div class="hide" id="slide_problemtype_crash_os_novalue">
						You must tick at least one operating system before continuing.
					</div>'
			),
			array(
				'id' => 'problemtype_docload',
				'title' => 'Your document looks wrong!',
				'buttons' => array(
								'previous' => true,
							),
				'content' => ''
			),
			array(
				'id' => 'problemtype_unreadable',
				'title' => 'Your document is unreadable!',
				'buttons' => array(
								'previous' => true,
							),
				'content' => ''
			),
			array(
				'id' => 'problemtype_ui',
				'title' => 'The UI is bad!',
				'buttons' => array(
								'previous' => true,
							),
				'content' => ''
			),
			array(
				'id' => 'problemtype_www',
				'title' => 'The website has a problem!',
				'buttons' => array(
								'previous' => true,
							),
				'content' => ''
			)
		);
	}
	
	/**
	 * Generate the 'help' section
	 */
	protected function help()
	{
		return array(
			array(
				'title' => 'LibreOffice Chatroom',
				'id' => 'irc',
				'content' => '<p>
					If you are unsure of anything, try asking for help in the
					<a href="http://webchat.freenode.net/?channels=libreoffice" target="_blank">LibreOffice chatroom.</a>
					Just enter a nickname, type what you see in the captcha, and click \'Connect\'.
					<em>
						This sort of chatroom is known as \'IRC\' - for some help on using it,
						<a href="http://irchelp.org/irchelp/new2irc.html" target="_blank">see here.</a>
					</em>
				</p>'
			),
			array(
				'title' => 'Make the file as small as possible',
				'id' => 'binary_chop',
				'content' => '<p>
					In order to be most helpful, please make documents as small as possible,
					while still causing the bug. The simplest way of doing this is known as
					<em>binary chopping</em>.
				</p> 
				<ol>
					<li>First, save a backup copy of the document.</li>
					<li>Open the document up in its native application (usually this is thw
						application the document was created in):
						<ul>
							<li>For .doc files, this will be Microsoft Word.</li>
							<li> For ODF files (those ending in .od*, where * is a letter) this
								will be LibreOffice.</li>
						</ul> 
					</li>
					<li>Then, repeatedly:
						<ol>
							<li>Delete the top half of the document.</li>
							<li>Save it as a new document.</li>
							<li>Open the document in LibreOffice.</li>
							<li>Is the problem still there?
								<ul>
									<li>If so, go back to the start of step 3.</li>
									<li>Otherwise, go back to the previous copy (or backup) and
										try step 3 again with the second half of the document.</li>
								</ul> 
							</li>
						</ol> 
					</li>
					<li>
						Once you have reduced the document down to the part that causes problems,
						(making sure to remove any personal or confidential information), attach
						it to the bug report.
					</li>
				</ol> '
			),
			array(
				'title' => 'How to get a backtrace (on Linux)',
				'id' => 'linux_backtrace',
				'content' => '<p>
					The backtrace is useful when the application crashes or freezes.
					You might use the following steps:    
				</p> 
				<ol>
					<li>Install the <tt>libreoffice*-debuginfo</tt> packages, if available.
						If you do not have them, the backtrace is less useful, but still could
						potentially provide at least some information.</li>
					<li>Start the debugger with the real binary and log the output:
						<pre>cd /opt/libreoffice/program</pre>
						<pre>gdb ./soffice.bin 2&gt;&amp;1 | tee /tmp/gdb.log</pre> </li>
					<li>Inside the debugger, start the application:
						<pre>run</pre>
						Should you need to specify options to the LibreOffice command line,
						use<code>run &lt;options&gt;</code>, like eg. <code>run -writer</code>,
						or <code>run /path/to/document.odt</code></li>
					<li>
						Do the steps to reproduce the application crash or freeze.
						If the freeze is the case, you need to press <tt>CTRL-C</tt>
						in gdb to get the gdb commandline back.
					</li>
					<li>Produce the backtrace:
						<pre>backtrace</pre></li>
					<li>Produce backtrace of all threads:
						<pre>thread apply all bt</pre></li>
					<li>Quit the debugger
						<pre>quit</pre></li>
					<li>Attach the whole <tt>gdb.log</tt> to the bug report.</li>
				</ol>'
			),
			array(
				'title' => 'Checking which fonts are installed',
				'id' => 'fonts_installed',
				'content' => '<p>Click on the name of the Operating System that your document looked strange on:</p>
					<ul>
						<li>
							<a href="javascript:showDivFromGroup(\'help_fonts_installed\', \'linux\')">Linux</a>
						</li>
						<li>
							<a href="javascript:showDivFromGroup(\'help_fonts_installed\', \'macOSX\')">Apple Mac OSX</a>
						</li>
						<li>
							<a href="javascript:showDivFromGroup(\'help_fonts_installed\', \'winXP\')">Microsoft Windows XP</a>
						</li>
						<li>
							<a href="javascript:showDivFromGroup(\'help_fonts_installed\', \'win7\')">Microsoft Windows 7</a>
						</li>
					</ul>
					
					<div class="hide" id="help_fonts_installed_winXP_div">
						<h4>Microsoft Windows XP</h4>
						<ol>
							<li>
								Open-up Control Panel. (Click on the start button, then \'Control Panel\'
								is one of the options on the right.)
							</li>
							<li>
								Find the icon named \'Fonts\' and double-click on it.
							</li>
							<li>
								You will be presented with a list of all the fonts that are installed.
								Scroll through them to see if the font you are looking for is there.
								If it is, then that font is installed.
							</li>
						</ol>
					</div>
					
					<div class="hide" id="help_fonts_installed_win7_div">
						<h4>Microsoft Windows 7</h4>
						<ol>
							<li>
								Open-up Control Panel. (Click on the start button, then \'Control Panel\'
								is one of the options on the right.)
							</li>
							<li>
								Enter \'fonts\' into the search box in the top-right of the Control Panel
								window, and press Enter.
							</li>
							<li>
								Under \'Fonts\', there should be a link that says \'View installed fonts\'.
								Click on it.
							</li>
							<li>
								You will be presented with a list of all the fonts that are installed.
								Scroll through them to see if the font you are looking for is there.
								If it is, then that font is installed.
							</li>
						</ol>
					</div>
					
					<div class="hide" id="help_fonts_installed_linux_div">
						<h4>Linux</h4>
						<ol>
							<li>Open a terminal window.</li>
							<li>Type-in
								<pre>fc-list | cut -d \':\' -f 1 | sort -u</pre>
								and press Enter.</li>
							<li>A list of the installed fonts will appear, in alphabetical order.</li>
						</ol>
					</div>
					
					<div class="hide" id="help_fonts_installed_macOSX_div">
						<h4>Apple Mac OSX</h4>
						<ol>
							<li>Open \'Finder\'.</li>
							<li>Navigate to the \'Applications\' folder.</li>
							<li>Scroll down to \'Font Book\', and double-click on it.</li>
							<li>You will be presented with a list of all the fonts that are
								installed, in alphabetical order.</li>
						</ol>
					</div>'
			)
		);
	}
}

$page = new BugSubmitPage();
echo $page->render();

?>
