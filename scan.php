<?php

//obtain absolute file path for the directory which this file is currently located
$directory = dirname(__FILE__);

//GLOBAL
$directoryList = array();

//build $directoryList global
listFolderFiles($directory);


//create array of all file types
$fileArray = array();
foreach($directoryList as $dir => $file){
    
    foreach($file as $filename){
        
        $extArray = explode('.', $filename);
        $fileExt = end($extArray);

        if(!array_key_exists($fileExt, $fileArray)){
            $fileArray[$fileExt] = array();
        }

        $fileArray[$fileExt][] = array(
            'dir'   => str_replace($directory, '', $dir) !== '' ? str_replace($directory, '', $dir) : '/',
            'file'  => $filename
        );
        
    }
    
}

ksort($fileArray);

//echo '<pre/>';
//echo var_export($fileArray, TRUE);



//$currentDirectory = '';
function listFolderFiles($dir){
    global $directoryList;
    
    $ffs = scandir($dir);
    $i = 0;
    $list = array();
    foreach ($ffs as $ff){
        if($ff != '.' && $ff != '..'){

            if(is_dir($dir . '/' . $ff)){
                
                listFolderFiles($dir . '/' . $ff);
                
            } else {
                
                $list[] = $ff;
                
            }
                    
        }
    }
    $directoryList[$dir] = $list;
    return $list;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>FileTypes</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <script>
            window.onload = function(){
              
                
              
            };
            
            function theOnClick(type){
                
                if(document.getElementById('type_' + type).style.display == 'none'){
                    
                    document.getElementById('type_' + type).style.display = 'block';
                    
                } else {
                    
                    document.getElementById('type_' + type).style.display = 'none';
                    
                }
                
                
                
            }
            
        </script>
        <style>
            .fileType{
                background-color:black;
                color:white;
                font-size:large;
                font-weight:bold;
                font-family:Arial;
                padding:5px;
                cursor:pointer;
                margin-bottom:5px;
            }
            .files table{
                width:100%;
            }
            .files table td{
                width:50%;                
            }
        </style>
        
    </head>
    <body>
        
        <h1>
            File Types
        </h1>
        <p>
            Below you will find a count of all file types within the directory and subdirectories of this file. 
            Clicking on one of the headings will expose the filenames along with the directory which they live (relative to the
            path of this file). <i>This file will not find files/directories that are above it's location</i>.
        </p>
        
        <?php foreach($fileArray as $type => $files): ?>
        
            <div class="fileType" onclick="theOnClick('<?php echo $type; ?>');" data-type="<?php echo $type; ?>">
                
                <?php echo $type; ?>
                
                <div style="float:right;">
                    <?php echo count($files); ?>
                </div>
                
            </div>
            <div class="files" id="type_<?php echo $type; ?>" style="display:none;">

                <table>
                <?php foreach($files as $fileInfo): ?>

                    <tr>
                        <td>
                            <?php echo $fileInfo['file']; ?>
                        </td>
                        <td>
                            <?php echo $fileInfo['dir']; ?>
                        </td>
                    </tr>

                <?php endforeach; ?>
                </table>

            </div>
        
        <?php endforeach; ?>
        
    </body>
</html>



