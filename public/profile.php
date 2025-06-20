<?php

include './components/header.php';
userAccess(["user", "landlord", "admin"]);
?>

<!-- container -->
<div class=" dashboard-container">
    <!--  -->
    <?php include './components/dashboard_side_nav.php' ?>
    <!--  -->
    <div class=" dashboard-main scrollbar transition-all duration-500">
        <?php include './components/dashboard_top_bar.php' ?>
        <!-- main -->
        <div class=" p-4">
            <div class=" flex justify-between gap-4 flex-wrap">
                <div class=" text-xl font-semibold">Profile</div>
                <div class="">
                    <a href="./reset_password.php" class=" text-xs font-semibold text-app-primary py-2 px-4 rounded border-2 border-app-primary bg-transparent hover:bg-app-primary hover:text-white">Reset Password</a>
                </div>
            </div>
            <div class=" mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <!--  -->
                <div class=" rounded-lg p-4 border shadow bg-white">
                    <div class=" text-sm text-primary font-semibold">Name:</div>
                    <div class=" text-lg"><?php echo htmlspecialchars($_SESSION['user']['first_name']) ?> <?php echo htmlspecialchars($_SESSION['user']['last_name']) ?></div>
                    <div class="">
                        <a href="./edit_name.php" class=" text-xs font-semibold py-1 px-3 rounded bg-transparent border-2 border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white">Edit Name</a>
                    </div>
                </div>
                <!--  -->
                <div class=" rounded-lg p-4 border shadow bg-white">
                    <div class=" text-sm text-primary font-semibold">Email:</div>
                    <div class=" text-lg"><?php echo htmlspecialchars($_SESSION['user']['email']) ?></div>
                </div>
                <!--  -->
                <div class=" rounded-lg p-4 border shadow bg-white">
                    <div class=" text-sm text-primary font-semibold">Type:</div>
                    <div class=" text-sm font-semibold uppercase"><?php echo htmlspecialchars($_SESSION['user']['user_type']) ?></div>
                </div>
                <!--  -->
                <div class=" rounded-lg p-4 border shadow bg-white">
                    <div class=" text-sm text-primary font-semibold">Account:</div>
                    <div class="">
                        <?php if ($_SESSION['user']['status'] === 'active') { ?>
                            <div class=" text-sm font-semibold text-green-500">Active</div>
                        <?php } elseif ($_SESSION['user']['status'] === 'inactive') { ?>
                            <div class=" text-sm font-semibold text-red-500">Inactive</div>
                        <?php } ?>
                    </div>
                    <div class=" mt-4">
                        <form action="./includes/auth/delete.php" method="post" onsubmit="return confirm(`Proceed to delete your account`)">
                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_SESSION['user']['user_id']) ?>">
                            <input type="hidden" name="location" value="profile">
                            <button type="submit" class=" text-xs font-semibold py-1 px-3 rounded bg-transparent border-2 border-red-500 text-red-500 hover:bg-red-500 hover:text-white">Delete Account</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end container -->

<?php

include './components/footer.php';
?>