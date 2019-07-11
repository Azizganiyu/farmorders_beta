<style>
.page_restrict{
    border:2px solid gray;
    width:50%;
    margin: 200px auto
}
@media (max-width: 576px) {
    .page_restrict{
        width:80%;
    }
}
.page_restrict h3{
    text-align: center;
    padding:  5px 0px 5px 0px;
    background-color: black;
    color: white;
    margin-top:0px;
}
.page_restrict p{
    
    text-align: center;
    padding:  5px 0px 5px 0px;
}
</style>
<div class="page_restrict">
    <h3>Restricted Page!</h3>
    <p> Sorry you dont have the clearance level for this page </p>
</div>

<?php exit(); ?>