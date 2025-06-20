<?php

include './components/header.php';
userAccess(['admin', 'landlord']);

$properties = fetchAll($pdo, "properties");

$sn = 1
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
            <div class=" flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class=" text-2xl text-center sm:text-left">Properties</div>
                <?php if ($_SESSION['user']['user_type'] === 'admin') { ?>
                    <div class="inline-block">
                        <a href="./property_add.php" class=" flex items-center justify-between sm:justify-normal md:text-lg gap-2 text-app-primary font-semibold hover:text-white transition border py-3 px-5 border-app-primary group bg-transparent relative">
                            <div class=" absolute top-0 left-0 bg-app-primary rounded-r-md h-full w-0 group-hover:w-[60%] transition-all duration-500"></div>
                            <div class=" absolute top-0 right-0 bg-app-primary rounded-l-md h-full w-0 group-hover:w-[60%] transition-all duration-500"></div>
                            <span class=" z-10 uppercase">Add New</span>
                            <i class="fa-solid fa-plus z-10"></i>
                        </a>
                    </div>
                <?php } ?>
            </div>
            <!--  -->
            <div class=" mt-4 pb-2 w-full overflow-x-auto scrollbar small-scrollbar">
                <table class="datatable display nowrap w-full min-w-[800px] border border-gray-200 rounded-lg overflow-hidden shadow text-sm text-left text-gray-700">
                    <thead class="bg-gray-300 text-gray-800 font-semibold">
                        <tr>
                            <th class="px-6 py-4">S/N</th>
                            <th class="px-6 py-4">Media</th>
                            <th class="px-6 py-4">Name</th>
                            <th class="px-6 py-4">Address</th>
                            <?php if ($_SESSION['user']['user_type'] === 'admin') { ?>
                                <th class="px-6 py-4">Landlord</th>
                            <?php } ?>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Type</th>
                            <th class="px-6 py-4">Availability</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($properties as $property) { ?>
                            <?php if ($_SESSION['user']['user_type'] === 'landlord') { ?>
                                <?php if ($property['landlord_id'] === $_SESSION['user']['user_id']) { ?>
                                    <tr data-href="dashboard_property_detail.php?id=<?php echo htmlspecialchars($property['property_id']) ?>" class="hover:bg-blue-50 transition cursor-pointer">
                                        <td class="px-6 py-4 whitespace-nowrap"><?php echo $sn++ ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class=" w-[50px] aspect-square rounded overflow-hidden relative">
                                                <?php 
                                                // Get first media file (could be image or video)
                                                $firstMedia = null;
                                                $isVideo = false;
                                                
                                                if ($property['images']) {
                                                    $firstMedia = explode(', ', $property['images'])[0];
                                                    // Check if it's a video file
                                                    $videoExtensions = ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm', 'mkv'];
                                                    $fileExtension = strtolower(pathinfo($firstMedia, PATHINFO_EXTENSION));
                                                    $isVideo = in_array($fileExtension, $videoExtensions);
                                                }
                                                
                                                if ($firstMedia && $isVideo) { ?>
                                                    <video class=" w-full h-full object-cover" muted>
                                                        <source src="<?php echo './includes/property/' . htmlspecialchars($firstMedia) ?>" type="video/<?php echo $fileExtension ?>">
                                                    </video>
                                                    <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-30">
                                                        <i class="fa-solid fa-play text-white text-lg"></i>
                                                    </div>
                                                <?php } elseif ($firstMedia) { ?>
                                                    <img src="<?php echo './includes/property/' . htmlspecialchars($firstMedia) ?>" class=" w-full h-full object-cover" alt="">
                                                <?php } else { ?>
                                                    <img src="./assets/showcase.png" class=" w-full h-full object-cover" alt="">
                                                <?php } ?>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class=" max-w-[300px] text-wrap line-clamp-2"><?php echo htmlspecialchars($property['name']) ?></div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class=" max-w-[200px] text-wrap line-clamp-2"><?php echo htmlspecialchars($property['address']) ?></div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class=" text-xs font-semibold uppercase"><?php echo htmlspecialchars($property['status']) ?></div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class=" text-xs font-semibold uppercase"><?php echo htmlspecialchars($property['type']) ?></div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class=" text-xs font-semibold uppercase"><?php echo htmlspecialchars($property['availability']) ?></div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <?php $landlord = fetchById($pdo, $property['landlord_id'], "users", "user_id") ?>
                                <tr data-href="dashboard_property_detail.php?id=<?php echo htmlspecialchars($property['property_id']) ?>" class="hover:bg-blue-50 transition cursor-pointer">
                                    <td class="px-6 py-4 whitespace-nowrap"><?php echo $sn++ ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class=" w-[50px] aspect-square rounded overflow-hidden relative">
                                            <?php 
                                            // Get first media file (could be image or video)
                                            $firstMedia = null;
                                            $isVideo = false;
                                            
                                            if ($property['images']) {
                                                $firstMedia = explode(', ', $property['images'])[0];
                                                // Check if it's a video file
                                                $videoExtensions = ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm', 'mkv'];
                                                $fileExtension = strtolower(pathinfo($firstMedia, PATHINFO_EXTENSION));
                                                $isVideo = in_array($fileExtension, $videoExtensions);
                                            }
                                            
                                            if ($firstMedia && $isVideo) { ?>
                                                <video class=" w-full h-full object-cover" muted>
                                                    <source src="<?php echo './includes/property/' . htmlspecialchars($firstMedia) ?>" type="video/<?php echo $fileExtension ?>">
                                                </video>
                                                <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-30">
                                                    <i class="fa-solid fa-play text-white text-lg"></i>
                                                </div>
                                            <?php } elseif ($firstMedia) { ?>
                                                <img src="<?php echo './includes/property/' . htmlspecialchars($firstMedia) ?>" class=" w-full h-full object-cover" alt="">
                                            <?php } else { ?>
                                                <img src="./assets/showcase.png" class=" w-full h-full object-cover" alt="">
                                            <?php } ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class=" max-w-[300px] text-wrap line-clamp-2"><?php echo htmlspecialchars($property['name']) ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class=" max-w-[200px] text-wrap line-clamp-2"><?php echo htmlspecialchars($property['address']) ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($landlord['first_name']) ?> <?php echo htmlspecialchars($landlord['last_name']) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class=" text-xs font-semibold uppercase"><?php echo htmlspecialchars($property['status']) ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class=" text-xs font-semibold uppercase"><?php echo htmlspecialchars($property['type']) ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class=" text-xs font-semibold uppercase"><?php echo htmlspecialchars($property['availability']) ?></div>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- end container -->

<?php

include './components/footer.php';
?>