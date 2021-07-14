<?php

namespace App\Http\Controllers;

use App\Models\course;
use App\Models\student;
use App\Models\User;
use App\Models\question;
use App\Models\weight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{
    function login()
    {
        $account = request('account');
        $password = request('password');
        $passwords = User::where('name', '=', $account)->pluck('password');
        $userId= User::where('name', '=', $account)->pluck('id');
        if ($passwords->isEmpty()) {
            dd('wrong password or account');
        } else {
            if ($password == $passwords[0]) {
                Auth::loginUsingId($userId[0], true);
                return Redirect::to('/ClassIndex');
                //return view('backend.ClassIndex');
            } else {
                dd('wrong password or account');
            }
        }
    }

    function LoginPage(){

        return view('backend.AdminLogin');
    }
    function ClassIndex(){
        if (Auth::check()){
            $classes=course::all();
            return view('backend.ClassIndex',[
                'classes'=> $classes,
            ]);
        }
        else{
            return ('you not login ya');
        }
    }
    function ClassCreate(){
        $ClassLink=str_random(10);
        course::create([
            'ClassName'=>request('ClassName'),
            'ClassLink'=>$ClassLink,
        ]);
        return Redirect::to('/ClassIndex');
    }
    function ClassShow($id){
        $class=course::Find($id);
        $students=student::where('classID', '=', $id)->get();
        return view('backend.ClassShow',[
            'id'=> $id,
            'class'=>$class,
            'students'=>$students,
        ]);
    }
    function Test(){
        //init AdminUser
        User::create(['name'=>'lanschen','password'=>'coffeec2',]);
        //import Question

        //Q1
        question::create([
            'Question'=>'一名團隊成員對該領導者最近友善的談話毫無回應，反而在擔心自己的福利。她似乎很沮喪，而且沒有按時完成工作。',
            'Option1'=>'幫助她逐步地學習完成工作的方法，並讓她知道沒有按時完成工作的後果。',
            'Option2'=>'詢問她打算如何重回正軌，並鼓勵她付諸實踐。',
            'Option3'=>'與她一起討論問題並設定目標。',
            'Option4'=>'觀察她的績效表現，並讓她知道自己隨時都能得到支持。',
            'S1'=>3,
            'S2'=>1,
            'S3'=>2,
            'S4'=>0,
            ]);

        //Q2
        question::create([
            'Question'=>'一名新團隊成員開始在工作中平穩地學習領導者分配的工作，且他的績效表現正在進步。他過早地要求想做更具挑戰性的工作。',
            'Option1'=>'稱讚他的進步，就他目前的工作指引他如何進一步提升，並解釋這種提升與工作全貌之間的關聯。',
            'Option2'=>'觀察其績效表現，在適當時機給予回饋。',
            'Option3'=>'鼓勵他學得很快，並詢問他關於想要做的新任務類型的意見。',
            'Option4'=>'強調他目前需要完成的工作之重要性。',
            'S1'=>3,
            'S2'=>0,
            'S3'=>2,
            'S4'=>1,
        ]);
        //Q3
        question::create([
            'Question'=>'一名團隊成員對於最近分配給他的一項常規專案頗有疑慮；過去你通常讓他單獨完成此類專案，他以往的績效表現和人際關係一直都很好。',
            'Option1'=>'就新專案給予詳細的指導，並允許他提出需要澄清的問題。',
            'Option2'=>'給予所需資源和權力，並在需要時適當監控。',
            'Option3'=>'將新工作拆解成一個個詳細的步驟，並向他說明。',
            'Option4'=>'討論他的疑慮，提供支持和鼓勵。',
            'S1'=>2,
            'S2'=>1,
            'S3'=>0,
            'S4'=>3,
        ]);
        //Q4
        question::create([
            'Question'=>'一名團隊成員提出她想要執行的一個改變；她很有熱情，並在該領域獲得諸多成就。你認為她的提議非常有價值。',
            'Option1'=>'讓她參與發展此改變計劃，同時持續鼓勵她。',
            'Option2'=>'指導她如何執行此改變。',
            'Option3'=>'仔細傾聽，提出需要澄清的問題，並讓她負責執行。',
            'Option4'=>'聽取她的建議，解釋此改變會如何對她的角色產生影響，並告訴她如何執行此改變。',
            'S1'=>2,
            'S2'=>0,
            'S3'=>3,
            'S4'=>1,
        ]);
        //Q5
        question::create([
            'Question'=>'一名團隊成員的績效表現在過去數個月中持續下滑。她並不關注是否能夠達成目標；她一直需要別人督促才能按時完成工作。',
            'Option1'=>'如有需要，觀察並監控她的績效表現一段時間。',
            'Option2'=>'向她說明需要完成的工作，並解釋其重要性；如有需要，回答她的問題。',
            'Option3'=>'明確告知她的角色、責任和目標，並密切監控她的表現。',
            'Option4'=>'與她進行友善的對話，並表達明確的擔憂。',
            'S1'=>0,
            'S2'=>2,
            'S3'=>3,
            'S4'=>1,
        ]);
        //Q6
        question::create([
            'Question'=>'基於前任主管對於該團隊成員的回饋，你始終密切監督並指引該團隊成員執行這項重要任務。她已經有值得讚許的回應，而現在你希望幫助她變得更有效率。',
            'Option1'=>'與她討論提升效率的想法，並鼓勵她更有效率地工作。',
            'Option2'=>'繼續密切監控並指導她的工作。',
            'Option3'=>'給她冒險的自由，以變得更有效率。',
            'Option4'=>'解釋工作效率為何重要，同時繼續提供指導和支持。',
            'S1'=>1,
            'S2'=>2,
            'S3'=>0,
            'S4'=>3,
        ]);
        //Q7
        question::create([
            'Question'=>'你正在考慮改變工作流程，你將這項工作分配給熟知工作流程的一名團隊成員。該成員表達擔心自己的工作量太大，可能會導致此任務出錯。',
            'Option1'=>'明確定義改變的流程，並仔細監督實施過程。',
            'Option2'=>'與團隊成員一起討論他擔心的問題，提供支持並表達對他的能力充滿信心。',
            'Option3'=>'傾聽他的疑慮，向他解釋為何新的流程可行，並在實施新流程時加以控制。',
            'Option4'=>'給予團隊成員執行新流程所需的權力及資源。',
            'S1'=>0,
            'S2'=>3,
            'S3'=>1,
            'S4'=>2,
        ]);
        //Q8
        question::create([
            'Question'=>'一名團隊成員的績效表現出色，與同事關係融洽；但如果讓她獨立負責一個重要專案，你還是感覺有些顧慮。',
            'Option1'=>'定期詢問專案的進展，並繼續觀察她的績效表現。',
            'Option2'=>'當你要做出必要決策時，詢問她的意見。',
            'Option3'=>'以界定清楚的方式循序漸進地指導她完成工作。',
            'Option4'=>'稱讚她的工作，並讓她參與專案的決策。',
            'S1'=>3,
            'S2'=>1,
            'S3'=>0,
            'S4'=>2,
        ]);
        //Q9
        question::create([
            'Question'=>'你被指派領導一個任務小組。組內的一名成員問題較多；他似乎不清楚任務小組的目標，而且只是偶爾出席既定行程的會議。從你的觀察來看，他出席會議時就像是參加社交聚會，而他的行為正在影響其他成員。',
            'Option1'=>'觀察任務小組的行為，並允許他們自己解決問題。',
            'Option2'=>'詢問他的建議，但要確保任務小組達成目標。',
            'Option3'=>'建立對於該員工明確的目標和期望，並與其溝通。',
            'Option4'=>'鼓勵該團隊成員提出看法，並肯定他所做出的任何正面貢獻。',
            'S1'=>0,
            'S2'=>2,
            'S3'=>3,
            'S4'=>1,
        ]);
        //Q10
        question::create([
            'Question'=>'一名以往有能力承擔工作責任的團隊成員，有點無法理解最近重新定義的部分標準。',
            'Option1'=>'傾聽該團隊成員的疑慮，消除他對新標準的疑慮。',
            'Option2'=>'明確表示新標準已經建立，並進行嚴密監督。',
            'Option3'=>'觀察該團隊成員的績效表現，以評估是否有必要採取進一步行動。',
            'Option4'=>'與該團隊成員談話，並解釋建立新標準的必要性。',
            'S1'=>2,
            'S2'=>0,
            'S3'=>1,
            'S4'=>3,
        ]);
        //Q11
        question::create([
            'Question'=>'你將一項任務分配給一名以前曾經做過此任務、並達到期望標準的團隊成員。過去，你讓她獨立完成，但是現在她希望得到你的建議和參與。',
            'Option1'=>'詳細指導她如何完成此任務。',
            'Option2'=>'讓她參與決策，向她保證會提供支持，並在合適的時候給予回饋。',
            'Option3'=>'與她討論如何充分利用她過去的績效表現，然後給予她如何完成此項工作的詳細指導。',
            'Option4'=>'繼續讓她獨立完成工作。',
            'S1'=>0,
            'S2'=>3,
            'S3'=>1,
            'S4'=>2,
        ]);
        //Q12
        question::create([
            'Question'=>'在最近的會議上，一名團隊成員滿腔熱情地陳述他的觀點。然而在會議中，其他同事不同意該團隊成員的觀點。這名成員有著傑出的工作成績；整體來說，此團隊在過去一年中合作融洽，並且所有成員都具備完成該任務的能力。',
            'Option1'=>'說服該團隊成員理解達成一致共識的必要性。',
            'Option2'=>'繼續觀察該團隊成員的行為，但讓他自行解決與其他團隊成員的意見分歧。',
            'Option3'=>'迅速而堅定地採取措施，讓團隊達成一致共識。',
            'Option4'=>'與該團隊成員探討意見分歧的狀況，並讓他知道你對他的支持。',
            'S1'=>1,
            'S2'=>3,
            'S3'=>0,
            'S4'=>2,
        ]);

        return('init complete');
    }
}
