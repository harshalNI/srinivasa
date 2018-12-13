<?php 
include('common/db.php');
if (session_status() != 2) {
    session_start();
}
$geturl = explode('/',$_SERVER['REQUEST_URI']);
$slug = $geturl[4];
$vistorId = isset($geturl[5]) ? $geturl[5] : '';
$sql = "SELECT * FROM blogs where blog_slug = '".$slug."'";
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
    $rec = $data[0];
} else {
	//echo "0 results";
}

$blogId = $data[0]['blog_id'];
//var_dump($blogId);exit;
// Getting the codes for the comments.
$sql = "SELECT * FROM blog_comments join visitors on user_id=visitor_id where blog_id = '$blogId' order by comment_id desc";
//print_r($sql);exit;
$commentResult = $conn->query($sql);
$commentData = array();
//echo"<pre>";print_r($sql);exit;
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $commentResult->fetch_assoc()) {
        $commentData[] = array(
            'comment_id' => $row['comment_id'],
            'comment' => $row['comment'],
            'created_at' => $row['created_at'],
            'username' => $row['name'],
            'user_id' => $row['user_id'],
        );
    }
} else {
    $commentData[] = '';
}

/**
* Getting the details of the user based on the UserId
*/
$sql = "SELECT * FROM visitors where visitor_id = '".$vistorId."'";
$result = $conn->query($sql);
$name = "Guest User";
//echo"<pre>";print_r($sql);exit;
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $name = $row['name'];
    }
    //$rec = $data[0];
} else {
    //echo "0 results";
}
//var_dump($name);exit;
?>
<!DOCTYPE html>
<html lang="en">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<head>
    <?php require('includes/header_links.php'); ?>
</head>

<body>
<style>

</style>
    <?php require('includes/header.php'); ?>
    <main class="block  ">
        <section class="contentsections  ">
            <div class="knowledge-hub-banner block innercontent subinnerbanner">

            </div>
            <div class="innercontent block knowledgehubcontainer bloginnerlayout">
                <div class="container-fluid">
                    <h1 class="maintitle boldfont text-center redcolor  text-capitalize"><?php echo $rec['blog_title'];?></h1>
                    <h3 class="lighterfont block text-center sectionpadding20 marginbottommaintitle">Written by <span class="recolor"><?php echo $rec['blog_author'];?></span> on <?php echo date('F j, Y', strtotime($rec['blog_created_on']));?></h3>
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 col-lg-offset-2 col-md-offset-2">
                            <div class="abouutuscontent block  text-justify">
                                <?php echo $rec['blog_description']; ?>

                                
                            </div>

                            <div class="subscribeforblogupdates block sectionpadding20 greenbackground ">
                                <h1 class="maintitle boldfont text-center whitecolor marginbottom15 text-capitalize">Subscribe for blog updates</h1>
                                <div class="form-group col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-12">
                                    <input type="text" placeholder="Email Address" class="form-control" />
                                </div>
                                <div class="form-group block text-center">
                                    <button type="button" class="btn ">Subscribe</button>
                                </div>
                            </div>

                            <div class="commentscontainer block sectionpadding20">
                                <header class="block marginbottom10 flex justify-content">
                                    <ul class="pull-left">
                                        <li>
                                            <a class="cursorpointer boldfont text-capitalize">
                                                <span id="comment_count"><?php echo !empty($commentData) ? sizeof($commentData) : 0?></span>&nbsp;
                                                Comments
                                            </a>
                                        </li>
                                    </ul>
                                    <ul class="pull-right ">
                                        <li class="dropdown loginforblogdetails">
                                            <a class="cursorpointer boldfont text-capitalize dropdown-toggle" data-toggle="dropdown">
                                                <span class="displayinlineblock"><i class="fa fa-comment" aria-hidden="true"></i>
                                                <span>0</span></span>
                                                Login&nbsp;<i class="fa fa-angle-down" aria-hidden="true"></i></a>
                                            <ul class="dropdown-menu nopad">
                                                <li><a href="../login.php?slug=<?php echo $data[0]['blog_slug']?>">Facebok</a></li>
                                            </ul>
                                        </li>
                                    </ul>

                                </header>

                                <div class="discussion-textarea block  discussionformstyling">
                                    <div class="form-group block">
                                        <textarea class="form-control" placeholder="Start Discussion" rows="3"
                                        onchange="appendComment(this)" id="comment_box"
                                        ></textarea>
                                    </div>
                                    <?php if (!empty($_SESSION['fb_access_token'])){ ?>
                                        <div class="form-group block">
                                        <button type="button" onclick="saveComment()" clasS="btn pull-right">Comment <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                                    </div>   
                                    <?php }?>
                                    <?php if(empty($_SESSION['fb_access_token'])) { ?>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                                            <h5 class=" block marginbottom10 boldfont brandname ">LOG IN WITH</h5>
                                            <ul class="block socialmediafootericons">
                                                
                                                <!-- onclick="checkLoginStatus()"  -->
                                                <li><a 
                                                href="../login.php?slug=<?php echo $data[0]['blog_slug']?>" 
                                                class="transition fb whitecolor"><i class="fa fa-facebook" aria-hidden="true"></i> </a>
                                                </li>
                                                
                                            </ul>
                                        </div>
                                        <!-- <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                            <h5 class=" block marginbottom10 boldfont brandname ">OR SIGN UP HERE</h5>
                                            <form action="/cmsfull/sign-up-and-comment.php" method="post">

                                                <input type="hidden" name="blog_slug" value="<?php echo $data[0]['blog_slug'] ?>">
                                                <input type="hidden" name="blog_id" value="<?php echo $data[0]['blog_id'] ?>">
                                                <input type="hidden" name="comment" id="form_comment">
                                                <div class="form-group block">
                                                    <input type="text" name="name" placeholder="Name" class="form-control" 
                                                    required />
                                                </div>
                                                <div class="form-group block">
                                                    <input type="email" name="email" placeholder="Email" class="form-control" required />
                                                </div>
                                                <div class="form-group block">
                                                    <input type="text" name="password" placeholder="Password" class="form-control" required/>
                                                </div>
                                                <div class="form-group block">
                                                    <p class="margin0">  By signing up, you agree to the Disqus Basic Rules, Terms of Service, and Privacy Policy.</p>
                                                </div>
                                               <div class="form-group block">
                                                        <button type="submit" clasS="btn pull-right"><i class="fa fa-arrow-right" aria-hidden="true"></i>SignUp & Comment</button>
                                                </div>
                                            </form>
                                        </div> -->

                                    </div>
                                    <?php }?>
                                </div>
                                <div class="commentscontainer block sectionpadding40" id="comment_container">
                                <?php 
                                if (!empty($commentData)) { ?>
                                
                                <?php foreach ($commentData as $key => $tempComment) { ?>
                                    <div class="comments flex marginbottom15">
                                        <div class="commonuserimage" >
                                        <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                                        </div>
                                        <div class="commentdetails">
                                            <h6 class="bluecolor block marginbottom10 boldfont">
                                                <?php echo $tempComment['username'];?>
                                                <span>on <?php echo date('d/M/Y H:i', $tempComment['created_at']);?></span>
                                            </h6>
                                            <textarea 
                                                id="<?php echo $tempComment['comment_id'];?>" 
                                                class="form-control block sectionpading20" 
                                                rows="3" 
                                                disabled><?php echo $tempComment['comment']?></textarea>
                                            <div class="comments-actions block sectionpadding10">
                                                <ul class="pull-left ">
                                                    <?php 
                                                    if(!empty($_SESSION['username']) || !empty($_SESSION['fb_access_token'])) { 
                                                        if($tempComment['user_id'] == $_SESSION['visitor_id']) {?>
                                                    <li><a class="editblog">Edit</a></li>
                                                    <li><a class="saveblog" id="button-<?php echo $tempComment['comment_id']?>" onclick="editComment(this)">Save</a></li>
                                                    <li><a onclick="deleteComment(this)" id="<?php echo $tempComment['comment_id']?>" class="deleteblog">Delete</a></li>
                                                    <?php }
                                                    }?>
                                                </ul>
                                            </div>
                                        </div>
                                             
                                    </div>
                                <?php } // comment foreach?>
                                <?php } else {// if ?>
                                    <div class="comments flex marginbottom15 text-center">
                                        No comments are given.
                                    </div>
                                <?php } // close of Else?>
                                    
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </section>
    </main>
    <?php require('includes/footer.php'); ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    
    <script>

        /**
        * Name : deleteComment
        * Purpose : To delete the comment from the user.
        */
        function deleteComment(object)
        {
            var commentId = object.id;
            $.ajax({
                url : '../../delete-comment.php',
                type : 'POST',
                data : { id : commentId},
                success : function(output) { 
                    if (output == 1) {
                        /*alert("success");
                        alert(output);*/
                        alertify.success("Comment is deleted");
                        $(object).parent().parent().parent().parent().parent().remove();
                    } else {
                        alertify.error("Unable to delete. Please refresh and try again.");
                    }
                    
                }, error : function(error) {
                    console.log(error);
                    alertify.error("Unable to delete. Please refresh and try again.");
                }
            });
        }
        /**
        * Name : editButton
        * Purpose : On clicking the edit button the comment box needs to be changed to 
        * editable.
        */
        function editButton(button)
        {
            alertify.error("Please Enter The Updated Comment");
            $(button).parent().parent().parent().prev().removeAttr("disabled");
            //$(button).parent().parent().pare.prev().focus();
        }
       
        /**
        * Name : editComment
        * Purpose : To edit the comment by the user.
        */
        function editComment(object) 
        {
            var buttonId = object.id;
            var divideId = buttonId.split("-");
            var commentId = divideId[1];
            var comment = $("#"+commentId).val();
            $.ajax({
                url : '../../edit-comment.php',
                type : 'POST',
                data : {comment : comment, commentId : commentId},
                success : function(output) { 
                    if (output == 1) {
                        alertify.success("Comment is saved");
                        $(object).parent().parent().parent().prev().attr("disabled","disabled");
                    } else {
                        alertify.error("Comment not saved. Please refresh and try again.");
                    }
                    
                }, error : function(error) {
                    console.log(error);
                }
            });

        }   

        /**
        * Name : appendComment()
        * Purpose : To append the comment to the signup form using 
        * "onchange()" function in the comment box.
        */
        function appendComment(object)
        {
            var comment = object.value;
            $("#form_comment").val(comment);
        }

        /**
        * Name : saveComment
        * Purpose : To save the comment and then append the comment below the comment box.
        */
        function saveComment()
        {

            var blogId = "<?php echo $blogId?>";
            var userId = "<?php echo $vistorId?>";
            var comment = $("#comment_box").val();
            if (comment == '' || comment == undefined) {
                alert("Please comment")
            } else {
                $.ajax({
                    url : '../../save-comment.php',
                    type : 'POST',
                    data : {comment : comment, blogId : blogId, userId : userId},
                    success : function(output) {
                        //alert(output);
                        console.log(output);
                        var result = JSON.parse(output);
                        var commentCount =  $("#comment_count").text();
                        commentCount = +commentCount + 1;
                        var commentCount =  $("#comment_count").text(commentCount);
                        // Emptying the comment once the comment is saved.
                        $("#comment_box").val('');
                        // Refering the comment start section
                        var commentContainer = document.getElementById("comment_container");
                            var flexDiv = document.createElement("div");
                            flexDiv.className = "comments flex marginbottom15";
                                var commonuserimageDiv = document.createElement("div");
                                commonuserimageDiv.className = "commonuserimage";
                                    var iTag = document.createElement("i");
                                    iTag.className = "fa fa-user-circle-o";
                                    iTag.setAttribute("aria-hidden", "true");
                                commonuserimageDiv.appendChild(iTag);
                                var commentDetailsDiv = document.createElement("div");
                                commentDetailsDiv.className = "commentdetails";
                                    var h6Tag = document.createElement("h6");
                                    h6Tag.className = "bluecolor block marginbottom10 boldfont";
                                    h6Tag.appendChild(document.createTextNode(result.username));
                                        var spanTag = document.createElement("span");
                                        spanTag.appendChild(document.createTextNode(" "+" On "+result.date));
                                    h6Tag.appendChild(spanTag);
                                    var textAreaTag = document.createElement("textarea");
                                    textAreaTag.className = "form-control block sectionpading20";
                                    textAreaTag.setAttribute("row", "3");
                                    textAreaTag.setAttribute("disabled", '');
                                    textAreaTag.id = result.id;
                                    textAreaTag.appendChild(document.createTextNode(result.comment));
                                    var commentActionDiv = document.createElement("div");
                                    commentActionDiv.className = "comments-actions block sectionpadding10";
                                        var ulTag = document.createElement("ul");
                                        ulTag.className = "pull-left";
                                            var liEditTag = document.createElement("li");
                                                var aEditTag = document.createElement("a");
                                                aEditTag.className = "editblog";
                                                aEditTag.setAttribute("onclick", "editButton(this)");
                                                aEditTag.appendChild(document.createTextNode("Edit"));
                                            liEditTag.appendChild(aEditTag);
                                            var liSaveTag = document.createElement("li")
                                                var aSaveTag = document.createElement("a");
                                                aSaveTag.className = "saveblog";
                                                aSaveTag.id = "button-"+result.id;
                                                aSaveTag.setAttribute("onclick", "editComment(this)");
                                                aSaveTag.appendChild(document.createTextNode("Save"));
                                            liSaveTag.appendChild(aSaveTag);
                                            var liDeleteTag = document.createElement("li");
                                                var aDeleteTag = document.createElement("a");
                                                aDeleteTag.className = "deleteblog";
                                                aDeleteTag.id = result.id;
                                                aDeleteTag.setAttribute("onclick", "deleteComment(this)");
                                                aDeleteTag.appendChild(document.createTextNode("Delete"));
                                            liDeleteTag.appendChild(aDeleteTag);
                                        ulTag.appendChild(liEditTag);
                                        ulTag.appendChild(liSaveTag);
                                        ulTag.appendChild(liDeleteTag);
                                    commentActionDiv.appendChild(ulTag);
                                commentDetailsDiv.appendChild(h6Tag);
                                commentDetailsDiv.appendChild(textAreaTag);
                                commentDetailsDiv.appendChild(commentActionDiv);
                            flexDiv.appendChild(commonuserimageDiv);
                            flexDiv.appendChild(commentDetailsDiv);                    
                        
                        //commentContainer.appendChild(flexDiv);
                        commentContainer.insertBefore(flexDiv, commentContainer.firstChild);

                    }, error : function(error) {
                        alert("Error");
                    }
                });
            }
        }
    </script>
    <script src="<?=base_url?>resources/bootstrap/jquery-3.1.1.min.js"></script>
    <script src="<?=base_url?>resources/bootstrap/bootstrap.min.js"></script>
    <script src="<?=base_url?>resources/bootstrap/jquery.min.js"></script>
    <script src="<?=base_url?>resources/bxslider/plugins/jquery.easing.1.3.js"></script>
    <script src="<?=base_url?>resources/bxslider/jquery.bxslider.min.js"></script>
    <script src="<?=base_url?>resources/scrollflow/scrollflow.min.js"></script>
    <script src="<?=base_url?>resources/alertifyjs/alertify.min.js"></script>
    <link rel="stylesheet" href="<?=base_url?>resources/alertifyjs/css/alertify.min.css"/>
    <link rel="stylesheet" href="<?=base_url?>resources/alertifyjs/css/themes/default.min.css"/>
    <script src="<?=base_url?>script/scripts.js"></script>
</body>

</html>
