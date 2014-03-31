<?if(!defined('BASEPATH'))header('HTTP/1.1 403 Forbidden');?>
<div class="navButton">
                    <?if(uri_string()!="home" && uri_string()!="" ){echo "<a href='home'>";}?>
    					
    			<div id="homeButtonImg" class="navButtonImg">
                        	<img src="images/homeButton.jpg" alt="Abtin Gramian - Home">
                        </div>
                    <?if(uri_string()!="home" && uri_string()!="" ){echo "</a>";}?>
                
                </div>
                <div class="navButton">
                    <?if(uri_string()!="about"){echo "<a href='about'>";}?>
                
                        <div id="aboutButtonImg" class="navButtonImg">
                        	<img src="images/aboutButton.jpg" alt="Abtin Gramian - About">
                    	</div>
                    <?if(uri_string()!="about"){echo "</a>";}?>
                
                </div>
                <div class="navButton">
                    <?if(uri_string()!="work"){echo "<a href='work'>";}?>
                
                        <div id="workButtonImg" class="navButtonImg">
                        	<img src="images/workButton.jpg" alt="Abtin Gramian - Work">
                    	</div>
                    <?if(uri_string()!="work"){echo "</a>";}?>
                
                </div>
                <div class="navButton">
                    <?if(uri_string()!="resume"){echo "<a href='resume'>";}?>
                        
                        <div id="resumeButtonImg" class="navButtonImg">
                        	<img src="images/resumeButton.jpg" alt="Abtin Gramian - Resume">
                    	</div>
                    <?if(uri_string()!="resume"){echo "</a>";}?>
                
                </div>
                <div class="navButton">
                    <?if(uri_string()!="contact"){echo "<a href='contact'>";}?>
                        
                        <div id="contactButtonImg" class="navButtonImg">
                        	<img src="images/contactButton.jpg" alt="Abtin Gramian - Contact">
                    	</div>
                    <?if(uri_string()!="contact"){echo "</a>";}?>
                
    		</div>
