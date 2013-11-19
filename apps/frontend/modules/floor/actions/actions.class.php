<?php
sfContext::getInstance()->getConfiguration()->loadHelpers(array(
    'Thumb',
    'Asset'
));

/**
 * floor actions.
 *
 * @package    spotiz
 * @subpackage floor
 * @author     Adrien Bokor <adrien@bokor.be>
 */
class floorActions extends sfActions
{
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeEdit(sfWebRequest $request)
    {
        
    }
    
    public function executeSap(sfWebRequest $request)
    {
        $request_body = file_get_contents('php://input');
        $param        = json_decode($request_body, true);
        
        // on recupere les images des tables, de la deco et du background. On renvois ca sous forme json
        if ($param['method'] == 'manager.getImages') {
            if (isset($param['params'][0])) {
                $floorArr = array();
                $images   = Doctrine::getTable('PlanTableImage')->createQuery('a')->leftjoin('a.Category c')->where('c.name = ?', $param['params'][0])->execute();
                $i        = 0;
                foreach ($images as $image) {
                    $floorArr[$i]['name']             = $image->getName();
                    $floorArr[$i]['imageLocation']    = '/uploads/floorTable/' . $image->getImg();
                    $floorArr[$i]['imageLocationMin'] = doThumb($image->getImg(), 'floorTable', array(
                        'width' => '80'
                    ));
                    $floorArr[$i]['type']             = $image->getCategory()->getName();
                    $i++;
                }
                $return['id']     = 0;
                $return['result'] = $floorArr;
                return $this->renderText(json_encode($return));
            }
        }
        // on met a jour le plan de table
        if ($param['method'] == 'manager.setFloor') {

            $id          = $param['params'][0]['oid'];
            $name        = $param['params'][0]['name'];
            $height      = $param['params'][0]['height'];
            $image       = $param['params'][0]['imageLocation'];
            $description = $param['params'][0]['description'];
            $width       = $param['params'][0]['width'];
            $visible     = $param['params'][0]['visible'];

            $floors = Doctrine::getTable('PlanTable') -> createQuery('a') -> leftjoin('a.PlanTableObject po') -> leftjoin('po.ObjectChairImage pci') -> leftjoin('pci.Category pcic') -> leftjoin('po.ObjectImage pi') -> leftjoin('pi.Category pic') -> where('id = ?', $id) -> limit(1) -> execute();
            foreach($floors as $floor){ 
                $floor->setName($name);
                $floor->setHeight($height);
                $floor->setBackgroundId(1);
                $floor->setDescription($description);
                $floor->setWidth($width);
                $floor->setVisible($visible);
                $floor->save();
            }

            // on supprime les relations et on met les nouvelles
            Doctrine_Query::create() -> delete() -> from('PlanTableObject po') -> where('po.plantable_id = ?', $id) -> execute();

            $tables = $param['params'][0]['tables'];

            // on ajoute les tables une par une
            foreach($tables as $table){
                $object = new PlanTableObject();
                $object -> setWidth($table['width']);
                $object -> setHeight($table['height']);
                $object -> setElipse($table['ellipse']);
                $object -> setVisible($table['visible']);
                $object -> setDescription($table['info']);
                $object -> setStatut($table['status']);
                $object -> setPlantableId($table['floorId']);
                $object -> setLocked($table['locked']);
                $object -> setX($table['x']);
                $object -> setY($table['y']);
                $object -> setRotation($table['rotation']);
                $object -> setName($table['name']);
                $object -> save();

            }

            

        }
        if ($param['method'] == 'manager.getFloors') {
        	$floors = Doctrine::getTable('PlanTable') -> createQuery('a') -> leftjoin('a.PlanTableBackground') -> leftjoin('a.PlanTableObject po') -> leftjoin('po.ObjectChairImage pci') -> leftjoin('pci.Category pcic') -> leftjoin('po.ObjectImage pi') -> leftjoin('pi.Category pic') -> execute() -> toArray();
            $floorArray = array();
            for($i=0; $i < count($floors); $i++){
                $floors[$i]['tables'] = $floors[$i]['PlanTableObject'];
                $floors[$i]['backgroundImage'] = '/uploads/floorTable/' . $floors[$i]['PlanTableBackground']['img'];
                $floors[$i]['imageLocation'] = '/uploads/floorTable/' . $floors[$i]['PlanTableBackground']['img'];
                $floors[$i]['oid'] = $floors[$i]['id'];
                unset($floors[$i]['PlanTableBackground']);
                unset($floors[$i]['PlanTableObject']);

            }
            $floors = array('id' => 0, 'result' => $floors);

            return $this->renderText(json_encode($floors, JSON_UNESCAPED_SLASHES));

            $json = '{"id":0,"result":[{"visible":false,"width":1024,"backgroundImage":"http://ec2.posios.com:80/posimages/MAIN/images/floors/floor5.jpg","bookingCapacity":0,"info":"",
    "tables":[{"ellipse":true,"visible":true,"status":"free","width":76,"type":"restaurant","info":"","floorId":1,"height":69,"numberOfClients":4,"oid":"1","rotation":0,"name":"","javaClass":"com.xudox.pos.server.datastructures.Table","locked":true,"companyId":10045,"tableOrder":0,"imageLocation":"http://ec2.posios.com:80/posimages/MAIN/images/tables/outsidetable.png","tableIds":null,"y":296,"chairImageLocation":"http://ws1.posios.com:8080/posimages/MAIN/images/whitechair.png","x":637,"zindex":0},
    {"ellipse":true,"visible":true,"status":"free","width":100,"type":"restaurant","info":"","floorId":1,"height":40,"numberOfClients":4,"oid":"1","rotation":0,"name":"","javaClass":"com.xudox.pos.server.datastructures.Table","locked":true,"companyId":10045,"tableOrder":0,"imageLocation":"http://ec2.posios.com:80/posimages/MAIN/images/tables/table5.png","tableIds":null,"y":68,"chairImageLocation":"http://ws1.posios.com:8080/posimages/MAIN/images/whitechair.png","x":423,"zindex":0},
    {"ellipse":true,"visible":true,"status":"free","width":76,"type":"restaurant","info":"","floorId":1,"height":69,"numberOfClients":4,"oid":"1","rotation":0,"name":"","javaClass":"com.xudox.pos.server.datastructures.Table","locked":false,"companyId":10045,"tableOrder":0,"imageLocation":"http://ec2.posios.com:80/posimages/MAIN/images/tables/outsidetable.png","tableIds":null,"y":547,"chairImageLocation":"http://ws1.posios.com:8080/posimages/MAIN/images/whitechair.png","x":948,"zindex":0},
    {"ellipse":true,"visible":true,"status":"free","width":76,"type":"restaurant","info":"","floorId":1,"height":69,"numberOfClients":4,"oid":"1","rotation":0,"name":"1","javaClass":"com.xudox.pos.server.datastructures.Table","locked":false,"companyId":10045,"tableOrder":0,"imageLocation":"http://ec2.posios.com:80/posimages/MAIN/images/tables/outsidetable.png","tableIds":null,"y":152,"chairImageLocation":"http://ws1.posios.com:8080/posimages/MAIN/images/whitechair.png","x":132,"zindex":0},
    {"ellipse":true,"visible":true,"status":"free","width":100,"type":"takeaway","info":"","floorId":1,"height":40,"numberOfClients":6,"oid":"1","rotation":0,"name":"ll","javaClass":"com.xudox.pos.server.datastructures.Table","locked":false,"companyId":10045,"tableOrder":0,"imageLocation":"http://ec2.posios.com:80/posimages/MAIN/images/tables/table3.png","tableIds":null,"y":169,"chairImageLocation":"http://ws1.posios.com:8080/posimages/MAIN/images/whitechair.png","x":255,"zindex":0}],"floorObjects":[],"height":689,"oid":17379,"name":"fr","javaClass":"com.xudox.pos.server.datastructures.Floor","companyId":10045,"imageLocation":"http://ec2.posios.com:80/posimages/MAIN/images/floors/floor5.jpg"},{"visible":false,"width":1024,"backgroundImage":"http://ec2.posios.com:80/posimages/MAIN/images/floors/floor8.png","bookingCapacity":0,"info":"edzedz","tables":[
    {"ellipse":true,"visible":true,"status":"free","width":100,"type":"restaurant","info":"","floorId":1,"height":40,"numberOfClients":4,"oid":"1","rotation":0,"name":"","javaClass":"com.xudox.pos.server.datastructures.Table","locked":false,"companyId":10045,"tableOrder":0,"imageLocation":"http://ec2.posios.com:80/posimages/MAIN/images/tables/table5.png","tableIds":null,"y":296,"chairImageLocation":"http://ws1.posios.com:8080/posimages/MAIN/images/whitechair.png","x":637,"zindex":0}],"floorObjects":[],"height":689,"oid":17441,"name":"dqdqsd","javaClass":"com.xudox.pos.server.datastructures.Floor","companyId":10045,"imageLocation":"http://ec2.posios.com:80/posimages/MAIN/images/floors/floor8.png"},{"visible":false,"width":1024,"backgroundImage":"http://ec2.posios.com:80/posimages/MAIN/images/floors/floor8.png","bookingCapacity":0,"info":"","tables":[],"floorObjects":[],"height":689,"oid":17479,"name":"sdfqs","javaClass":"com.xudox.pos.server.datastructures.Floor","companyId":10045,"imageLocation":"http://ec2.posios.com:80/posimages/MAIN/images/floors/floor8.png"}]}';
            return $this->renderText($json);
        }

        if ($param['method'] == 'manager.addFloor') {
            $name        = $param['params'][0]['name'];
            $height      = $param['params'][0]['height'];
            $image       = $param['params'][0]['imageLocation'];
            $description = $param['params'][0]['info'];
            $width       = $param['params'][0]['width'];
            $visible     = $param['params'][0]['visible'];
            $floor       = new PlanTable();
            $floor->setName($name);
            $floor->setHeight($height);
            $floor->setBackgroundId(1);
            $floor->setDescription($description);
            $floor->setWidth($width);
            $floor->setVisible($visible);
            $floor->save();
            $array           = array();
            $array['id']     = 0;
            $array['result'] = $floor->getId();
            return $this->renderText(json_encode($array));
            
        }
    }
}
