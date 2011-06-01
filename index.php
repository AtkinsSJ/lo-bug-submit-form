<?php

require_once('include/Mustache.php');

class BugSubmitPage extends Mustache
{
	protected $_template = ''; // Content Template
	
	public function __construct()
	{
		$this->_template = file_get_contents('templates/template.mustache');
	}
	
	public function render()
	{
		return parent::render($this->_template);
	}
	
	/**
	 * Generate the 'help' section
	 */
	protected function help()
	{
		return array(
			array('title' => 'LibreOffice Chatroom',
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
			array('title' => 'Make the file as small as possible',
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
			array('title' => 'How to get a backtrace (on Linux)',
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
			array( 'title' => 'Checking which fonts are installed',
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
