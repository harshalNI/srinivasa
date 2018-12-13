<?php include('common/db.php');
$sql = "SELECT * FROM blogs where blog_status = 1 order by blog_id desc";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	// output data of each row
	while($row = $result->fetch_assoc()) {
		$data[] = array(
				'blog_id' => $row['blog_id'],
				'blog_title' => $row['blog_title'],
				'blog_slug' => $row['blog_slug'],
				'blog_author' => $row['blog_author'],
				'blog_image' => $row['blog_image'],
				'blog_description' => $row['blog_description'],
				'blog_created_on' => $row['blog_created_on'],
		);
	}
} else {
	echo "0 results";
}
//echo"<pre>";print_r($data);exit;
//$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html" />

<head>
    <?php require('includes/header_links.php'); ?>
</head>

<body>
    <?php require('includes/header.php'); ?>
    <main class="block lightgraybg ">
        <section class="contentsections  ">
            <div class="knowledge-hub-banner block innercontent innerbanner hidden">

            </div>
            <div class="block text-center marginbottom10 postablogbtn postablogbtnbg ">
                        <a  class="postablog text-uppercase boldfont displayinlineblock cursorpointer greenbackground  whitecolor transitionforbutton"><i class="fa fa-plus" aria-hidden="true"></i></a>
                    </div>
            <div class="block text-center   ">
                        <span  class="text-capitalize boldfont displayinlineblock  brandname ">Post A Blog</span>
                    </div>
            <div class="innercontent block knowledgehubcontainer">
                <div class="container-fluid">
                    <div class="block text-center marginbottommaintitle postablogbtn hidden">
                        <a  class="postablog text-uppercase boldfont displayinlineblock cursorpointer greenbackground  whitecolor">Post A Blog</a>
                    </div>
                    <h1 class="maintitle boldfont redcolor marginbottommaintitle">Blog</h1>
                    <div class="knowledgehubmaincategorieslisting block bloglistingcontaoiner">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-6 col-xs-6">
                                <a href="blog-details.php/<?php echo $data[0]['blog_slug'];?>">
                                    <div class="knowledgehubdiv block whitebg  transition marginbottom15">
                                        <img src="http://www.bigappcompany.in/demos/finball-admin/admin/assets/blogs/original/<?php echo $data[0]['blog_image']?>" class="img-responsive" alt="">
                                        <div class="blogdetails block text-left">
                                            <h5 class="boldfont ">
                                                <?php echo $data[0]['blog_title'];?>
                                            </h5>
                                            <h6 class="sectionpadding10  block"><span class="redcolor"><?php echo $data[0]['blog_author'];?></span> Created on
                                                <?php echo date('F j, Y', strtotime($data[0]['blog_created_on']));?>
                                            </h6>
                                            <?php 
$string = strip_tags($data[0]['blog_description']);
    
    if (strlen($string) > 500) {
    	
    	// truncate string
    	$stringCut = substr($string, 0, 500);
    	
    	// make sure it ends in a word so assassinate doesn't become ass...
    	$string = substr($stringCut, 0, strrpos($stringCut, ' ')).' ...';
    }
?>
                                            <p class="margin0 transition ">
                                                <?php echo $string; ?>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="row">

                            <?php foreach(array_slice($data,1) as $key=>$rec):
                            //echo"<pre>";print_r($rec);exit;
                            //To display Description

                            ?>


                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
                                <a href="blog-details.php/<?php echo $rec['blog_slug'];?>">
                                    <div class="knowledgehubdiv block whitebg text-center transition marginbottom15">
                                        <img src="http://www.bigappcompany.in/demos/finball-admin/admin/assets/blogs/original/<?php echo $rec['blog_image']?>" class="img-responsive" alt="">
                                        <div class="blogdetails block text-left">
                                            <h6 class="sectionpadding10  block"><span class="redcolor"><?php echo $rec['blog_author'];?></span> Created on
                                                <?php echo date('F j, Y', strtotime($rec['blog_created_on']));?>
                                            </h6>
                                            <?php 
$string = strip_tags($rec['blog_description']);
    
    if (strlen($string) > 120) {
    	
    	// truncate string
    	$stringCut = substr($string, 0, 120);
    	
    	// make sure it ends in a word so assassinate doesn't become ass...
    	$string = substr($stringCut, 0, strrpos($stringCut, ' ')).' ...';
    }
?>

                                            <h5 class="boldfont ">
                                                <?php echo $rec['blog_title']; ?>
                                            </h5>
                                            <h6 class="sectionpadding10  block fcolor">
                                                <?php echo $string;?>
                                            </h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php endforeach;?>
                            <!--<div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
                                <a href="blog-details.php">
                                    <div class="knowledgehubdiv block whitebg text-center transition marginbottom15">
                                        <img src="images/knowledge-hub/knowledge-hub-2.jpg" class="img-responsive" alt="">
                                        <div class="blogdetails block text-left">
                                            <h6 class="sectionpadding10  block"><span class="redcolor">Sandeep</span> Created on 5th July 2017</h6>
                                            <h5 class="boldfont ">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
                                <a href="blog-details.php">
                                    <div class="knowledgehubdiv block whitebg text-center transition marginbottom15">
                                        <img src="images/knowledge-hub/knowledge-hub-3.png" class="img-responsive" alt="">
                                        <div class="blogdetails block text-left">
                                            <h6 class="sectionpadding10  block"><span class="redcolor">Sandeep</span> Created on 5th July 2017</h6>
                                            <h5 class="boldfont ">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
                                <a href="blog-details.php">
                                    <div class="knowledgehubdiv block whitebg text-center transition marginbottom15">
                                        <img src="images/knowledge-hub/knowledge-hub-1.png" class="img-responsive" alt="">
                                        <div class="blogdetails block text-left">
                                            <h6 class="sectionpadding10  block"><span class="redcolor">Sandeep</span> Created on 5th July 2017</h6>
                                            <h5 class="boldfont ">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
                                <a href="blog-details.php">
                                    <div class="knowledgehubdiv block whitebg text-center transition marginbottom15">
                                        <img src="images/knowledge-hub/knowledge-hub-2.jpg" class="img-responsive" alt="">
                                        <div class="blogdetails block text-left">
                                            <h6 class="sectionpadding10  block"><span class="redcolor">Sandeep</span> Created on 5th July 2017</h6>
                                            <h5 class="boldfont ">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
                                <a href="blog-details.php">
                                    <div class="knowledgehubdiv block whitebg text-center transition marginbottom15">
                                        <img src="images/knowledge-hub/knowledge-hub-3.png" class="img-responsive" alt="">
                                        <div class="blogdetails block text-left">
                                            <h6 class="sectionpadding10  block"><span class="redcolor">Sandeep</span> Created on 5th July 2017</h6>
                                            <h5 class="boldfont ">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
                                <a href="blog-details.php">
                                    <div class="knowledgehubdiv block whitebg text-center transition marginbottom15">
                                        <img src="images/knowledge-hub/knowledge-hub-3.png" class="img-responsive" alt="">
                                        <div class="blogdetails block text-left">
                                            <h6 class="sectionpadding10  block"><span class="redcolor">Sandeep</span> Created on 5th July 2017</h6>
                                            <h5 class="boldfont ">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
                                <a href="blog-details.php">
                                    <div class="knowledgehubdiv block whitebg text-center transition marginbottom15">
                                        <img src="images/knowledge-hub/knowledge-hub-3.png" class="img-responsive" alt="">
                                        <div class="blogdetails block text-left">
                                            <h6 class="sectionpadding10  block"><span class="redcolor">Sandeep</span> Created on 5th July 2017</h6>
                                            <h5 class="boldfont ">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>



        </section>
    </main>

    <div class="postablogpopup transition">
        <div class="contactusform postablogcontent col-lg-4 col-md-4 col-sm-5 col-xs-12 whitebg transition">
            <div class="closepopup ">
                <a class="closemodalpopup cursorpointer"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
            </div>
            <h1 class="maintitle boldfont redcolor marginbottommaintitle text-capitalize text-center">Post a Blog</h1>
            <form method='post'  id='gform_1' action=''>
            <div class="form-group block flex">
                <div class="iconfortextboxrepresentation">
                    <i class="fa fa-user transition" aria-hidden="true"></i>
                </div>
                <input type="hidden" name="from_email" value="noreply@spotsoon.com"/>
                <input type="hidden" name="subject" value="Blog Posting Request"/>
                <input type="hidden" name="to_email" value="neeraj@finnirv.com"/>
                <input type="hidden" name="to_cc" value=""/>
                <input placeholder="First Name" type="text" name="name">
                <div class="block borderbottom"></div>
            </div>

            <div class="form-group block flex nomargin">
                <div class="iconfortextboxrepresentation">
                    <i class="fa fa-comment-o transition" aria-hidden="true"></i>
                </div>
                <input placeholder="Attach a file" class="image" type="file" name="file[]">
                <div class="block borderbottom"></div>

            </div>
            <p class="text-center boldfont">Attach a word file</p>
            <div class="form-group block">
                <button type="button" class="btn block contact_submit">Send</button>
            </div>
                </form>
        </div>
        
    </div>
    <?php require('includes/footer.php'); ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <script src="resources/bootstrap/jquery-3.1.1.min.js"></script>
    <script src="resources/bootstrap/bootstrap.min.js"></script>
    <script src="resources/bootstrap/jquery.min.js"></script>
    <script src="resources/bxslider/plugins/jquery.easing.1.3.js"></script>
    <script src="resources/bxslider/jquery.bxslider.min.js"></script>
    <script src="resources/scrollflow/scrollflow.min.js"></script>
    <script src="script/scripts.js"></script>
    <script>
		jQuery(document).ready(function(){
			jQuery(".contact_submit").click(function(e){
			    e.preventDefault();
			    var fdata = new FormData()
			    fdata.append("product_name",jQuery("#gform_1").serialize());

			//Use this code to send files in email as attachment if upload option is there
			  var files = jQuery(".image")[0].files;
			  var numFiles = jQuery("input:file")[0].files.length;
			  if(numFiles > 0){
			  jQuery.each(files, function (index, value) {
				  if(jQuery(".image")[0].files.length>0)
				       fdata.append("file[]",jQuery(".image")[0].files[index])
				});
			  } 
			  //Use above code to send files in email as attachment if upload option is there
			       jQuery.ajax({
			        type: 'POST',
			        url: "http://bigappcompany.co.in/demos/cms/contact",
			        data:fdata,
			        contentType: false,
			        processData: false, 
			        success: function(response)
			        {
			            if(response == '1'){
			                 alert("Thanks for Posting a Blog..");
                            $(".closemodalpopup ").click();
			            }
			        }
			    })
			});
		});
    </script>
</body>

</html>
