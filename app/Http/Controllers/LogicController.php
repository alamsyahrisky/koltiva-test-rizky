<?php

namespace App\Http\Controllers;

use App\Models\Temporary;
use App\Models\TemporaryDetail;
use App\Models\TemporaryResult;
use Illuminate\Http\Request;

class LogicController extends Controller
{
    public function index()
    {
        $check = Temporary::all()->count();
        $temporary = Temporary::all();
        $detail = TemporaryDetail::all();
        $result = TemporaryResult::first();

        return view('pages.logic',[
            'total' => $check,
            'temporary' => $temporary,
            'detail' => $detail,
            'result' => ($result != null ? $result : ''),
        ]);
    }

    public function store_dummy(Request $request)
    {
        $data = $request->all();
        $dummy_array = [];
        $result = [];
        for ($i=1; $i <= (int) $data['jumlah_tahun']; $i++) { 
            array_push($dummy_array,$i);
            $result[$i] = $this->count_year($dummy_array);
            Temporary::create([
                'year' => $i,
                'text' => $result[$i]['text'],
                'result' => $result[$i]['hasil'],
            ]);
        }

        return redirect()->route('logic-index');
    }

    public function destroy($id)
    {
        $detail = TemporaryDetail::find($id);
        $detail->delete();
        $this->count_result();

        return redirect()->route('logic-index')->with(['success' => 'Successfully deleted data']);;
    }

    public function create_dummy(Request $request)
    {
        $data = $request->all();
        $check = $data['year'] - $data['age'];
        $check_data = Temporary::where('year',$check)->first();

        if($check <= 0){
            return redirect()->route('logic-index')->with(['error' => 'Hasil Pengurangan minus']);
        }

        if($data['year'] <= 0 && $data['age'] <= 0){
            return redirect()->route('logic-index')->with(['error' => 'Input tidak boleh minus']);
        }

        if($check_data){
            TemporaryDetail::create([
                'age' => $data['age'],
                'year' => $data['year'],
                'result' => $check,
            ]);
            
            $this->count_result();
        }else{
            return redirect()->route('logic-index')->with(['error' => 'Hasil Pengurangan Tidak ada di referensi']);
        }

        return redirect()->route('logic-index')->with(['success' => 'Successfully saved data']);;
    }

    public function count_result()
    {
        $detail = TemporaryDetail::all();
        $total_data = TemporaryDetail::all()->count();
        $total = 0;
        foreach ($detail as $key => $value) {
            $getdetail = Temporary::where('year',$value['result'])->first();
            $total += $getdetail->result;
        }
        $avg = $total / $total_data;
        $result = TemporaryResult::where('avg','>',0)->first();
        if($result){
            $result->update([
                'avg' => $avg
            ]);
        }else{
            $result = TemporaryResult::create([
                'avg' => $avg
            ]);
        }
        return $result; 
    }

    public function count_year($year)
    {
        $jumlah = 1;
        $penjumlahan = '1';
        foreach ($year as $key => $value) {
            if($value != count($year)){
                $jumlah += $value;
                $penjumlahan .= ' + '.$value;
            }else{
                if(count($year) > 1){
                    $penjumlahan .= ' =';
                }
            }
        }

        $result['hasil'] = $jumlah;
        $result['text'] = $penjumlahan;
        
        return $result;
    }
}
