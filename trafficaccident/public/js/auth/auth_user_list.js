//const { data } = require("jquery");

const url_location = "/api/auth/user_list";

var add_btn = document.getElementById('add_user');
add_btn.addEventListener('click', function () {

    let token = localStorage.getItem('jwt');
    /*var user_name = document.getElementById('user_name').value;
    var employer = document.getElementById('employer').value;
    var burean = document.getElementById('burean').value;
    var permission_level = document.getElementById('permission_level').value;
    var account = document.getElementById('account').value;
    var password = document.getElementById('password').value;
    var password_confirmation = document.getElementById('password_confirmation').value;
    var email = document.getElementById('email').value;*/
    var user_name = ["張國棟","傅祥光","邱中正","張峻翔","陳富國","林義博","劉彥鴻","劉廷暉","黎素吟","牟玉海","龔黔人","吳獻堂","沈佳瑾","林芯名","蘇靖元","李黃珮琦","吳漢琳","梁雅淳","陳頤珊","黃岳麟","鍾一榮","程幼佩","戴和明","龔士哲","尤正廷","鄭純情","李益杰","林慶村","彭森志","陳賢德","謝昊宸","洪石川","賴文榮","盧紹文","吳稚偉","曾尹政","賴建華","莊敏宗","曾昭榮","曾志偉","楊義楓","?建榮","蔡政諺","楊?逞","胡家銘","陳文明","高璋賢","謝東文","洪振?","曾光煜","黃財源","徐茂雄","王竣鴻","王宗漢","劉昶亨","?建安","溫威龍","余勇強","方裕翔","莊欽淵","楊樹寰","徐蜀震","費添龍","?坤?","蕭永茂","聶世傑","莊寓勝","陳振銘 ","林顯宗","蔡聰傑","蘇全源","林嘉祥","侯榮家","林敏盛","吳正文","侯善容","賴志成","尤裕棠","林彥睿","宗陸志強","羅貴騰","詹勳昌","李佳瑩","杜信諭","周黃文科","黃港發","董懷方","吳佳銘","梁資佳","邱志慶","陳義忠","邱克峰","黃才展","林源智","陳建誠","張博文","高天進","林茂成","古文慶","高慶德","荊國彥","邱新成","楊若琳","高兆龍","樊永福","康榮宗","林志弘","?綮騫","潘慶鴻","邱文孝","陳志慶","胡傅金堂","唐?天","徐名坤","張淵瑜","潘國基","謝明恭","蔡蘭貴","黃士睿","鄭志舷","徐朝貴","陳泰山","吳彥均","羅文龍","陳鼎喬","徐金祥","王建超","彭德昌","張能為","王利平","徐俊煜","郭恒嘉","簡文龍","劉建平","蔡宇鑫","吳聲亮","田政福","洪世博","邱宏仁","邱成發","溫紫能","翁國欽","黃自成","蘇洵杰","劉明昌","涂慶華","胡松俊仁","邱文豐","高正吉","姜林一源","曾明元","陳金雄","郭譯隆","陳清源","鄭世華","林忠意","胡健意","王敏嚴","田敏偉","黃冠?","王玹勝","田英傑","陳權泰","林宗永","馬培翔","莊俊男","許義郎","陳泰成","黃建宏","高武雄","江家銘","施得義","蘇相吉","林中信","許原豪","何順吉","張又天","張克勤","劉紹弘","陳榮仕","高國樑"];
    var employer = ["交通隊","交通隊","交通隊","交通隊","交通隊","交通隊","交通隊","交通隊","交通隊","交通隊","交通隊","交通隊","交通隊","交通隊","交通隊","交通隊","交通隊","交通隊","交通隊","交通隊","保安隊","保安隊","保安隊","少年隊","少年隊","少年隊","臺東分局","臺東分局","臺東分局","臺東勤務指揮中心","臺東勤務指揮中心","臺東勤務指揮中心","臺東勤務指揮中心","臺東勤務指揮中心","臺東勤務指揮中心","臺東第五組","臺東第五組","臺東車禍處理小組","臺東第一組","臺東第一組","臺東分局中興派出所","臺東分局中興派出所","臺東分局寶桑派出所","臺東分局寶桑派出所","臺東分局馬蘭派出所","臺東分局馬蘭派出所","臺東分局富岡派出所","臺東分局富岡派出所","臺東分局永樂派出所","臺東分局永樂派出所","臺東分局豐里派出所","臺東分局豐里派出所","臺東分局卑南分駐所","臺東分局卑南分駐所","臺東分局南王派出所","臺東分局南王派出所","臺東分局初鹿派出所","臺東分局初鹿派出所","臺東分局利嘉派出所","臺東分局利嘉派出所","臺東分局東興派出所","臺東分局東興派出所","臺東分局溫泉派出所","臺東分局溫泉派出所","臺東分局知本派出所","臺東分局知本派出所","臺東分局綠島分駐所","臺東分局綠島分駐所","臺東分局公館派出所","臺東分局公館派出所","臺東分局蘭嶼分駐所","臺東分局建蘭派出所","臺東分局東清派出所","臺東分局朗島派出所","大武分局","大武分局","大武勤務指揮中心","大武勤務指揮中心","大武勤務指揮中心","大武勤務指揮中心","大武勤務指揮中心","大武第四組","大武第四組","大武車禍處理小組","大武第一組","大武第一組","大武分局美和派出所","大武分局美和派出所","大武分局太麻里分駐所","大武分局太麻里分駐所","大武分局金峰分駐所","大武分局金峰分駐所","大武分局金崙派出所","大武分局金崙派出所","大武分局多良派出所","大武分局多良派出所","大武分局台土?拍出所","大武分局台土?拍出所","大武分局新化派出所","大武分局新化派出所","大武分局大武派出所","大武分局大武派出所","大武分局達仁分駐所","大武分局達仁分駐所","大武分局森永派出所","大武分局森永派出所","關山分局","關山分局","關山分局","關山勤務指揮中心","關山勤務指揮中心","關山勤務指揮中心","關山勤務指揮中心","關山勤務指揮中心","關山第四組","關山第四組","關山車禍處理小組","關山第一組","關山第一組","關山分局池上分駐所","關山分局池上分駐所","關山分局錦安派出所","關山分局錦安派出所","關山分局電光派出所","關山分局關山派出所","關山分局關山派出所","關山分局瑞源派出所","關山分局瑞源派出所","關山分局瑞豐派出所","關山分局瑞豐派出所","關山分局鹿野分駐所","關山分局鹿野分駐所","關山分局鸞山派出所","關山分局鸞山派出所","關山分局延平分駐所","關山分局延平分駐所","關山分局武陵派出所","關山分局武陵派出所","關山分局崁頂派出所","關山分局崁頂派出所","關山分局海端分駐所","關山分局海端分駐所","關山分局龍泉派出所","關山分局龍泉派出所","關山分局初來派出所","關山分局初來派出所","關山分局霧鹿派出所","關山分局霧鹿派出所","關山分局利稻派出所","關山分局利稻派出所","關山分局向陽派出所","關山分局向陽派出所","成功分局","成功分局","成功勤務指揮中心","成功勤務指揮中心","成功勤務指揮中心","成功勤務指揮中心","成功勤務指揮中心","成功第四組","成功第四組","成功車禍處理小組","成功第一組","成功第一組","成功分局都蘭派出所","成功分局都蘭派出所","成功分局東河分駐所","成功分局東河分駐所","成功分局泰源派出所","成功分局泰源派出所","成功分局都歷派出所","成功分局都歷派出所","成功分局新豐派出所","成功分局忠孝派出所","成功分局忠孝派出所","成功分局寧埔派出所","成功分局寧埔派出所","成功分局長濱分駐所","成功分局長濱分駐所","成功分局樟原派出所","成功分局樟原派出所"];
    var burean = ["臺東縣警察局","臺東縣警察局","臺東縣警察局","臺東縣警察局","臺東縣警察局","臺東縣警察局","臺東縣警察局","臺東縣警察局","臺東縣警察局","臺東縣警察局","臺東縣警察局","臺東縣警察局","臺東縣警察局","臺東縣警察局","臺東縣警察局","臺東縣警察局","臺東縣警察局","臺東縣警察局","臺東縣警察局","臺東縣警察局","臺東縣警察局","臺東縣警察局","臺東縣警察局","臺東縣警察局","臺東縣警察局","臺東縣警察局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","臺東分局","大武分局","大武分局","大武分局","大武分局","大武分局","大武分局","大武分局","大武分局","大武分局","大武分局","大武分局","大武分局","大武分局","大武分局","大武分局","大武分局","大武分局","大武分局","大武分局","大武分局","大武分局","大武分局","大武分局","大武分局","大武分局","大武分局","大武分局","大武分局","大武分局","大武分局","大武分局","大武分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","關山分局","成功分局","成功分局","成功分局","成功分局","成功分局","成功分局","成功分局","成功分局","成功分局","成功分局","成功分局","成功分局","成功分局","成功分局","成功分局","成功分局","成功分局","成功分局","成功分局","成功分局","成功分局","成功分局","成功分局","成功分局","成功分局","成功分局","成功分局","成功分局","成功分局"];
    var permission_level = ["100","100","100","100","100","100","100","100","100","100","100","100","100","100","100","100","100","100","100","100","100","100","100","100","100","100","200","200","200","200","200","200","200","200","200","200","200","200","200","200","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","200","200","200","200","200","200","200","200","200","200","200","200","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","200","200","200","200","200","200","200","200","200","200","200","200","200","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","200","200","200","200","200","200","200","200","200","200","200","200","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300","300"];
    var account = ["sa0669","a120766171","kc011","f90458","ttp268","kb010156","kgb866","rockdx72","ttp0239","9YXOYBQI","n123","ctw0107","scc1107","police723","cqmda","betty","henry2004kk","0247chun","gghh0315","cc228986","v531047","ttp023","077HH2X3M","xyz","mikeyusir","ttp127","tpp001","lin236","dob0519","dr4axr","CAK9Y468","ttp074","ttp160","hgqv65ry","taiv1024","im801185","ttp1274","v328951","ttp155","TA0662","subway3114","aa9848","vgchicken","3o1gur","5MQ2WO15","AA4116","I8N573KJ","kc029","m38211","v120407479","kc309","ttp204","jhwang0224","wangjh39","changheng0107","V120880709","kevin0326","62NC75F1","Ifei2468","ttp196","kc272","f580m7gg","v120068196","v120529907","4075rdv4","ttp249","dm010039","ttp267","ttp098","ttp255","ttp172","ttp123","ttp115","ttp220","CYR3J803","ttp006","cu790r","JCHAZBJE","midexcellent864","ecc38a17","N9498ER8","h8983","AA4066","pt42g029","jhwk","sgcap188","SB44FLK9","ck3059","HENXXZAT","ttp149","ttp090","7q37wr","vwucpswn","ttp118","e79588","cq3fwr","n118","n136","n153","S24J1O04","melancholy","ttp025","XY2EXAW4","n146","6r4kxr","n139","lin611258","kc007","ttp359","ttp273","cheng01","kc5433","kc313","kc137","kc263","kc102","smg95","fu3k7yek","PXYGUQWC","kxx3p6yy","kc065","kc136","kc066","kc064","NFLJKCLY","kc042","kc070","kc129","kc105","kc073","wka33qag","213","ttp106","am7vnkdb","QJBPYH2F","ttp113","kc190","kc5760","kc153","kc053","kc315","kc063","WZ3574XT","kc251","kc108","kc072","kc106","kc2450","F0RYGR56","XUTX5N6N","6986VLI4","49OMLY68","kk641149","yuan0226","kc012","lin039","okla0218","ttp086","tmw851681","bp771267","2079bb","ttp201","ps781068","sgcap101","a821203","5877k3j3","kc019","sgcap070","ttp148","sgcap079","chiang6315","ttp139","sgcap105","ttp276","ttp241","sgcap107","sgcap120","kc266","sgcap067","t122030358","sgcap141"];
    var password = "Npa20000";
    var password_confirmation = "Npa20000";
    //var email = NULL;
    for(i=150;i<181;i++){

    if (password != password_confirmation) {
        swal("建立失敗", "請確認密碼是否正確", "error");
    } else {
        /*let formData = new FormData();
        formData.append('user_name', user_name); //required
        formData.append('employer', employer); //required
        formData.append('burean', burean); //required
        formData.append('permission_level', permission_level); //required
        formData.append('account', account); //required
        formData.append('password', password); //required
        formData.append('password_confirmation', password_confirmation); //required
        formData.append('email', email); //required*/

        let formData = new FormData();
        formData.append('user_name', user_name[i]); //required
        formData.append('employer', employer[i]); //required
        formData.append('burean', burean[i]); //required
        formData.append('permission_level', permission_level[i]); //required
        formData.append('account', account[i]); //required
        formData.append('password', password); //required
        formData.append('password_confirmation', password_confirmation); //required
        formData.append('email', email); //required

        axios({
            method: 'POST',
            url: url_location,
            headers: {
                "Accept": "application/json",
                "Authorization": "Bearer " + token
            },
            data: formData,
        }).then(function (response) {
            if (response.data['status'] == "Success") { 
                myTable.ajax.url(url_location).load();

                $('#addModal').modal('toggle');

                document.getElementById('user_name').value = "";
                document.getElementById('employer').value = "";
                document.getElementById('burean').value = "";
                document.getElementById('permission_level').value = "";
                document.getElementById('account').value = "";
                document.getElementById('password').value = "";
                document.getElementById('password_confirmation').value = "";
                document.getElementById('email').value = "";

                swal("新增成功", "", "success");


            }
        }).catch(function (response) {

            if (response.response.data.message == "The given data was invalid..") {

                swal("新增失敗", "帳號已被使用", "error");

            }

        })

    }
    }

});
var change_user_data_btn = document.getElementById('change_user_data');
change_user_data_btn.addEventListener('click', function () {
    let token = localStorage.getItem('jwt'); 
    var user_name = document.getElementById('user_name_change').value;
    var employer = document.getElementById('employer_change').value;
    var burean = document.getElementById('burean_change').value;
    var permission_level = document.getElementById('permission_level_change').value;
    var account = document.getElementById('account_change').value;
    var password = document.getElementById('password_change').value;
    var email = document.getElementById('email_change').value;
    axios({
        method: 'get',
        url: "/api/changedata",
        params: {           
            user_name:user_name,
            employer:employer,
            burean:burean,
            permission_level:permission_level,
            account:account,
            password:password,
            email:email,
        },
        headers: {
            "Accept": "application/json",
            "Authorization": "Bearer " + token
        },
    }).then(function (response) {
        console.log(response.data['username']);
        console.log(response.data['employer']);
        console.log(response.data['burean']);
        console.log(response.data['permission_level']);
        console.log(response.data['account']);
        console.log(response.data['password']);
        console.log(response.data['email']);
        swal("修改成功", "", "success");
    })

});