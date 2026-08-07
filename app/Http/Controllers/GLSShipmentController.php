<?php

namespace App\Http\Controllers;

use App\Models\Payment\Payment;
use App\Models\Parcel;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Http;
use App\Models\PMM\Order\PMMOrder;
use App\Models\UppSell;
use  App\Models\PMM\gls\profile;
use App\Models\PMM\CC\PmmOrderNote;
use App\Models\PMM\PMMRats;

class GLSShipmentController extends Controller
{
    public $adddparcel_url;
    public $token_url;
    public $shipment_url;
    public $service_url;
    public $base_url;
    public $sede;
    public $customer_code;
    public $contract_code;
    public $password;  
    public $check_adress;  
 public function __construct() {
    $this->service_url=config('myconfig.gls.service_url');
    $this->adddparcel_url=config('myconfig.gls.addparcel_url');
    $this->shipment_url=config('myconfig.gls.shipment_url');
    $this->token_url=config('myconfig.gls.token_url');
    $this->sede=config('myconfig.gls.sede');
    $this->customer_code=config('myconfig.gls.customer_code');
    $this->contract_code=config('myconfig.gls.contract_code');
    $this->password=config('myconfig.gls.password');
    $this->base_url=config('myconfig.gls.base_url');
    $this->check_adress=config('myconfig.gls.check_adress');
 }
public function closeWorkDay(Request $request,$id)
{
        $tran=Parcel::find($id);
        $p_data=json_decode($tran->response_payload);
        $r_data=json_decode($tran->request_payload);
          
       $profile_get=Payment::find($tran->payment_id);
  

     $gls_profile_id=$profile_get->link->product->gls_profile_id;
     
     $gls=profile::find($gls_profile_id);
        
        $seda=$gls->sede;
        $customer_code=$gls->customer_code;
        $contract_code=$gls->contract_code;
   
        $password=$gls->password;
         $url = $this->service_url.'/CloseWorkDay';

    // GLS expects decimal with comma
    $peso = str_replace('.', ',', $request->weight);
    $xmlInfoParcel = <<<XML
            <Info>
             <SedeGls>{$seda}</SedeGls>
                <CodiceClienteGls>{$customer_code}</CodiceClienteGls>
                <PasswordClienteGls>{$password}</PasswordClienteGls>
            <ListParcel> 
            <Parcel> 
                <Data>{$p_data->Parcel->DataSpedizione}</Data> 
                <RiferimentiCliente>{$tran->id}</RiferimentiCliente> 
                <DenominazioneDestinatario>{$p_data->Parcel->DenominazioneDestinatario}</DenominazioneDestinatario> 
                <CittaDestinatario>{$p_data->Parcel->CittaDestinatario}</CittaDestinatario>
                <IndirizzoDestinatario>{$p_data->Parcel->IndirizzoDestinatario}</IndirizzoDestinatario> 
                <TotaleColli>{$p_data->Parcel->TotaleColli}</TotaleColli> 
                <PesoSpedizione>{$p_data->Parcel->PesoSpedizione}</PesoSpedizione> 
                <StatoSpedizione>IN ATTESA DI CHIUSURA.</StatoSpedizione> 
            </Parcel>
            </ListParcel> 
            </Info>
            XML;
// dd($r_data,$p_data,$xmlInfoParcel);
    $response = Http::asForm()
        ->timeout(60)
        ->retry(3, 1000)
        ->post($url, [
            'XMLCloseInfoParcel' => $xmlInfoParcel
        ]);

    // Load XML
    $xmlBody = simplexml_load_string($response->body());
    if ((string) $xmlBody === 'OK') {
            $tran->is_close_work_day=1;
            $tran->save();
            return redirect()->back()->with([
                'toast' => [
                    'heading' => 'Sucess',
                    'message' =>"Confirmed Successfully",
                    'type' => 'success',
                ]
            ]);
        } else {
           return redirect()->back()->with([
                'toast' => [
                    'heading' => 'Error!',
                    'message' =>"Cannot be confirmed",
                    'type' => 'danger',
                ]
            ]);
        }
}

function closeWorkDay_number(Request $request,$id){
         $tran=Parcel::find($id);
        $p_data=json_decode($tran->response_payload);
        $r_data=json_decode($tran->request_payload);
          
       $profile_get=Payment::find($tran->payment_id);
  

     $gls_profile_id=$profile_get->link->product->gls_profile_id;
     
     $gls=profile::find($gls_profile_id);
        
        $seda=$gls->sede;
        $customer_code=$gls->customer_code;
        $contract_code=$gls->contract_code;
   
        $password=$gls->password;
         $url = $this->service_url.'/CloseWorkDayByShipmentNumber';
// dd($url);
    // GLS expects decimal with comma
    $peso = str_replace('.', ',', $request->weight);
    $xmlInfoParcel = <<<XML
            <Info> 
                <SedeGls>{$seda}</SedeGls> 
                <CodiceClienteGls>{$customer_code}</CodiceClienteGls> 
                <PasswordClienteGls>{$password}</PasswordClienteGls> 
                <Parcel> 
                <NumeroDiSpedizioneGLSDaConfermare>{$tran->ShipmentNumber}</NumeroDiSpedizioneGLSDaConfermare> 
                </Parcel> 
            </Info>
            XML;
// dd($r_data,$p_data,$xmlInfoParcel);
    $response = Http::asForm()
        ->timeout(60)
        ->retry(3, 1000)
        ->post($url, [
            '_xmlRequest' => $xmlInfoParcel
        ]);

    // Load XML
    $xmlBody = simplexml_load_string($response->body());
    // dd($xmlBody->DescrizioneErrore);
    // dd($xmlInfoParcel,$xmlBody->Parcel->esito);
    if ((string) $xmlBody->Parcel->esito === 'OK') {
            $tran->is_close_work_day=1;
            $tran->save();
            return redirect()->back()->with([
                'toast' => [
                    'heading' => 'Sucess',
                    'message' =>"Confirmed Successfully",
                    'type' => 'success',
                ]
            ]);
        } else {
            // dd($xmlBody->Parcel->esito)
           return redirect()->back()->with([
                'toast' => [
                    'heading' => 'Error!',
                    'message' =>(string)$xmlBody->Parcel->esito,
                    'type' => 'danger',
                ]
            ]);
        }
}
function deleteByShipmentNumber(Request $request,){
         $tran=Parcel::where('ShipmentNumber',$request->shipment_number)->first();
        $p_data=json_decode($tran->response_payload);
        $r_data=json_decode($tran->request_payload);
          
       $profile_get=Payment::find($tran->payment_id);
  

     $gls_profile_id=$profile_get->link->product->gls_profile_id;
     
     $gls=profile::find($gls_profile_id);
        
        $seda=$gls->sede;
        $customer_code=$gls->customer_code;
        $contract_code=$gls->contract_code;
        $password=$gls->password;
   
        $password=$gls->password;
         $url = $this->service_url.'/DeleteSped';
         $response = Http::asForm()->post($url, [
        'SedeGls' => $seda,
        'CodiceClienteGls' =>$customer_code,
        'PasswordClienteGls' => $password,
        'NumSpedizione' => $request->shipment_number
        ]);
        $xmlBody = simplexml_load_string($response->body());
        if($response->status()==200){
            $message = (string)$xmlBody;
            
            if($message=="Eliminazione della spedizione ".$request->shipment_number." avvenuta."){
                $tran->shipment_status="Cancelled";
                $tran->save();
               return response()->json([
                'status'=>'success',
                'message'=>$message
                ]);
            }else{
               return response()->json([
                'status'=>'error',
                'message'=>$message
                ]); 
            }
            
        }else{
             return response()->json([
                'status'=>'error',
                'message'=>"Cannot be cancelled"
                ]);
        }
}
public function testAddParcel(Request $request)
{
  
    $tran=Payment::find($request->payment_id);
    
     $gls_profile_id=$tran->link->product->gls_profile_id;
     $gls=profile::find($gls_profile_id);
     
     $seda=$gls->sede;
     $customer_code=$gls->customer_code;
     $contract_code=$gls->contract_code;
     $password=$gls->password;
    $url = $this->adddparcel_url;

$recipient = [
    'name'       => $request->recipient_name,
    'phone'      => $request->recipient_phone,
    'address'    => $request->recipient_address,
    'city'       => $request->recipient_city,
    'postalcode' => $request->recipient_postalcode,
    'province'   => $request->recipient_province,
    'country'    => $request->recipient_country,
    'weight'     => $request->weight,
    'payment_id' => $request->payment_id
];

$validation = $this->validateRecipientAddressGLS($recipient);
$encryp_payment_id=unique_encrypt($tran->id);
$total_price=$request->total_price;
$usd_amount=0;
$local_amount=0;
    if($tran->crouncy!='USD')
        {
            $usd_rate = PMMRats::where('symbol',$tran->currency.'/USD')->value('rate');
            $usd_amount = $total_price * ($usd_rate ?? 1);
        }else
        {
            $usd_amount = $total_price;     
        }
    if($tran->crouncy!='USD')
        {
             $rate = PMMRats::where('symbol', 'USD/'.$tran->currency)->value('rate');
             $local_amount=$usd_amount * ($rate ?? 1);
            
        }else
        { 
            $local_amount= $usd_amount;    
        }
        $local_amount=round($local_amount,2);
if($validation['status'] == false){
    return response()->json([
        'status' => 'error',
        'message' => 'Invalid address shipment'
    ], 500);
}
    $peso = str_replace('.', ',', $request->weight);
    $note=$request->note;
    $note=$note."\n #Telefono: ".$tran->phone;
    $note=$note."\n #Nome prodotto: ".$tran->link->product->name;
    
    if (!empty($request->upsell_id)){
     $upsell=UppSell::find($request->upsell_id);
    $note=$note."\n #Quantità: ".$tran->quantity.' '.$upsell->name;
    }else
    {
        $note=$note."\n #Quantità: ".$tran->quantity;
    }

    $xmlInfoParcel = <<<XML
<Info>
    <SedeGls>{$seda}</SedeGls>
    <CodiceClienteGls>{$customer_code}</CodiceClienteGls>
    <PasswordClienteGls>{$password}</PasswordClienteGls>
    <RagioneSocialeMittente>{$request->sender_name}</RagioneSocialeMittente>
        <IndirizzoMittente>{$request->sender_address}</IndirizzoMittente>
        <LocalitaMittente>{$request->sender_city}</LocalitaMittente>
        <ZipcodeMittente>{$request->sender_postalcode}</ZipcodeMittente>
        <ProvinciaMittente>{$request->sender_province}</ProvinciaMittente>
        <TelefonoMittente>{$request->sender_phone}</TelefonoMittente>
        <NazioneMittente>{$request->sender_country}</NazioneMittente>
    <Parcel>
        <CodiceContrattoGls>{$this->contract_code}</CodiceContrattoGls>
        <RagioneSociale>{$request->recipient_name}</RagioneSociale>
        <ContatoreProgressivo>{$encryp_payment_id}</ContatoreProgressivo>
        <TelefonoDestinatario>{$tran->phone}</TelefonoDestinatario>
        <TelefonoMittente>{$request->sender_phone}</TelefonoMittente>
        <ModalitaIncasso>CONT</ModalitaIncasso>
        <ImportoContrassegno>{$total_price}</ImportoContrassegno>
        <Indirizzo>{$request->recipient_address}</Indirizzo>
        <Localita>{$request->recipient_city}</Localita>
        <Zipcode>{$request->recipient_postalcode}</Zipcode>
        <Provincia>{$request->recipient_province}</Provincia>
        <TelefonoMittente>{$request->recipient_phone}</TelefonoMittente>
         <Nazione>{$request->recipient_country}</Nazione>
        <Bda>BC</Bda>
        <Colli>{$request->weight}</Colli>
        <PesoReale>{$peso}</PesoReale>
        <TipoPorto>F</TipoPorto>
        <TipoSpedizione>N</TipoSpedizione>
         <EmailDestinatario>{$request->recipient_email}</EmailDestinatario> 
         <NoteSpedizione>{$note}</NoteSpedizione>
         <Cellulare1>{$tran->phone}</Cellulare1>
         <ServiziAccessori>25</ServiziAccessori>
    </Parcel>
</Info>
XML;

    $response = Http::asForm()
        ->timeout(60)
        ->retry(3, 1000)
        ->post($url, [
            'XMLInfoParcel' => $xmlInfoParcel
        ]);

    // Load XML
    $xmlBody = simplexml_load_string($response->body());
    if (isset($xmlBody->Parcel)) {
        $parcel = $xmlBody->Parcel;
        // GLS shipment number
        $shipmentNumber = (string) $parcel->NumeroSpedizione;

        // GLS PDF label (agar available ho)
        $labelURL = (string) $parcel->PdfLabel ?: (string) $parcel->Zpl;
////// update adress
     $tran->name=$request->recipient_name;
    $tran->email = $request->recipient_email; 
    $tran->address = $request->recipient_address; 
    $tran->phone = $request->recipient_phone; 
    $tran->postalcode =$request->recipient_postalcode; 
    $tran->city =$request->recipient_city; 
    $tran->state =$request->recipient_province; 
    // $tran->local_amount =$local_amount; 
    // $tran->usd_amount =$usd_amount; 
    $tran->country =$request->recipient_country; 
    $tran->save();
   $order = $tran->order;

if ($request->upsell_id) {
    $order->cc_status = "Accepted + Up Sell";
} else {
    $order->cc_status = "Accepted";
}
      $order->save();
$Parcel =  Parcel::create([
    'payment_id'        => $request->reference,
    'user_id'        => auth()->user()->id,
    'ShipmentNumber'    => (string)$parcel->NumeroSpedizione,
    'shipment_date'     => (string)$parcel->DataSpedizione,
    'bda'               => (string)$parcel->Bda,
    'weight'            => (string)$parcel->PesoSpedizione,
    'LabelURL'          => (string)$parcel->PdfLabel ?: null,
    'zpl'               => (string)$parcel->Zpl ?: null,
    'ship_note'         => (string)$parcel->NoteSpedizione ?: null,
    'total_packages'    => (string)$parcel->TotaleColli ?: null,
    'cod_amount'        => (string)$parcel->ImportoCassegno ?: 0,
    'total_cod'         => (string)$parcel->TotaleImportodaIncassare ?: 0,
    'sender_name'       => $request->sender_name,
    'sender_address'    => $request->sender_address,
    'sender_city'       => $request->sender_city,
    'sender_postalcode' => $request->sender_postalcode,
    'sender_province'   => $request->sender_province,
    'sender_country'    => $request->sender_country,
    'sender_phone'      => $request->sender_phone,
    'shipment_status'     => "Created",
    'phone'             => $request->recipient_phone,
    'address'           => $request->recipient_address,
    'city'              => $request->recipient_city,
    'name'              => $request->recipient_name,
     'email'             => $request->recipient_email, 
    'postalcode'        => $request->recipient_postalcode,
    'country'           => $request->recipient_country,
    'request_payload'           => json_encode($xmlInfoParcel),
    'response_payload'           => json_encode($xmlBody),
    'total_price'       =>$request->total_price,
    'upp_sell_id'       =>$request->upsell_id,
    'ship_note'     =>$request->note
]);
       if(!empty($request->upsell_id))
        {
       $UpSell=UppSell::find($request->upsell_id);
     
       $UpSell->parcel_id=$Parcel->id;
       $UpSell->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Shipment created and saved successfully!',
            'shipment_number' => $shipmentNumber,
            'label_url' => $labelURL
        ]);

    } elseif (isset($xmlBody->Parcel->NoteSpedizione) && !empty($xmlBody->Parcel->NoteSpedizione)) {
        // GLS returned an error message
        return response()->json([
            'status' => 'error',
            'message' => (string) $xmlBody->Parcel->NoteSpedizione
        ], 500);

    } else {
        // Unexpected response
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid response from GLS'
        ], 500);
    }
}


private function validateRecipientAddressGLS($recipient)
{

      $profile_get=Payment::find($recipient['payment_id']);
     $gls_profile_id=$profile_get->link->product->gls_profile_id;
     $gls=profile::find($gls_profile_id);
  
     $seda=$gls->sede;
     $customer_code=$gls->customer_code;
     $contract_code=$gls->contract_code;
     $password=$gls->password;
    $soapEnvelope = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
               xmlns:xsd="http://www.w3.org/2001/XMLSchema"
               xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <CheckAddress xmlns="https://checkaddress.gls-italy.com/">
<SedeGls>{$seda}</SedeGls>
                <CodiceClienteGls>{$customer_code}</CodiceClienteGls>
                <PasswordClienteGls>{$password}</PasswordClienteGls>
      <SiglaProvincia>{$recipient['province']}</SiglaProvincia>
      <Cap>{$recipient['postalcode']}</Cap>
      <Localita>{$recipient['city']}</Localita>
      <Indirizzo>{$recipient['address']}</Indirizzo>
    </CheckAddress>
  </soap:Body>
</soap:Envelope>
XML;
       

        $response = Http::withHeaders([
            'Content-Type' => 'text/xml; charset=utf-8',
            'SOAPAction' => 'https://checkaddress.gls-italy.com/CheckAddress'
        ])->withBody($soapEnvelope, 'text/xml; charset=utf-8')
          ->timeout(60)
          ->post($this->check_adress);
        
        $xmlBody = simplexml_load_string($response->body());
      
        $result = $xmlBody->xpath('//*[local-name()="CheckAddressResult"]');
         
        if ($result && isset($result[0])) {
            $message = (string)$result[0];
            if (stripos($message, 'Destinazione corretta') !== false) {
                return ['status' => true, 'message' => $message];
            }
        }
        
        $addressList = $xmlBody->xpath('//*[local-name()="AddressList"]/*[local-name()="Address"]');
       
        if (!empty($addressList)) {
            $suggestions = [];
            foreach ($addressList as $addr) {
                $suggestions[] = (string)$addr->Comune . ', ' . (string)$addr->SiglaProvincia;
            }
           $messageNode = $xmlBody->xpath('//*[local-name()="AddressList"]/*[local-name()="Esito"]');
           
                $message = isset($messageNode[0]) ? trim((string)$messageNode[0]) : 'Invalid address';
                if (stripos($message, 'Destinazione corretta') !== false) {
                    return [
                        'status' => true
                    ];
                } else {
                    return [
                        'status' => false
                    ];

                }
                
        }
}

public function fetchadresss(Request $request)
{
    $request->validate([
        'city'       => 'required|string',
        'postalcode' => 'required|string',
        'address'    => 'required|string',
        'province'   => 'nullable|string'
    ]);
   
        $profile_get=Payment::find($request->payment_id);
     $gls_profile_id=$profile_get->link->product->gls_profile_id;
     $gls=profile::find($gls_profile_id);
        
        $seda=$gls->sede;
        $customer_code=$gls->customer_code;
        $contract_code=$gls->contract_code;
        $password=$gls->password;
      
    // 🔹 SOAP XML
    $soapEnvelope = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
               xmlns:xsd="http://www.w3.org/2001/XMLSchema"
               xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <CheckAddress xmlns="https://checkaddress.gls-italy.com/">
      <SedeGls>{$seda}</SedeGls>
      <CodiceClienteGls>{$customer_code}</CodiceClienteGls>
      <PasswordClienteGls>{$password}</PasswordClienteGls>
      <SiglaProvincia>{$request->province}</SiglaProvincia>
      <Cap>{$request->postalcode}</Cap>
      <Localita>{$request->city}</Localita>
      <Indirizzo>{$request->address}</Indirizzo>
    </CheckAddress>
  </soap:Body>
</soap:Envelope>
XML;
    $response = Http::withHeaders([
        'Content-Type' => 'text/xml; charset=utf-8',
        'SOAPAction'   => 'https://checkaddress.gls-italy.com/CheckAddress'
    ])
    ->withBody($soapEnvelope, 'text/xml; charset=utf-8')
    ->timeout(60)
    ->post($this->check_adress);

    $xmlBody = simplexml_load_string($response->body());

    // ✅ Exact match
    $result = $xmlBody->xpath('//*[local-name()="CheckAddressResult"]');
    if ($result && isset($result[0])) {
        $message = (string)$result[0];
        if (stripos($message, 'Destinazione corretta') !== false) {
            return response()->json([
                'status' => true,
                'message' => $message
            ]);
        }
    }

    // ❌ Multiple suggestions
    $addressList = $xmlBody->xpath('//*[local-name()="AddressList"]/*[local-name()="Address"]');
    
    if (!empty($addressList)) {
        $list = [];

        foreach ($addressList as $addr) {
            $list[] = [
                'region'   => (string)$addr->DescrizioneRegione,
                'province' => (string)$addr->SiglaProvincia,
                'city'     => (string)$addr->Comune,
                'cap'      => (string)$addr->Cap,
                'eta'      => (string)$addr->TempoDiResa,
                'zone'     => (string)$addr->Zona,
                'hard'     => (string)$addr->LocalitaDisagiata,
                'street'   => (string)$addr->Indirizzo,
            ];
        }
         
        return response()->json([
            'status' => false,
            'list' => $list
        ]);
    }

    return response()->json([
        'status' => false,
        'message' => 'No address found'
    ]);
}

 public function edit($id)
{
    $shipment = Payment::find($id);
    if(!$shipment) {
        return response()->json(['success'=>false, 'message'=>'Shipment not found']);
    }
    return response()->json(['success'=>true, 'data'=>$shipment]);
}
public function cancelParcel(Request $request)
{
    $request->validate([
        'shipment_number' => 'required|string',
    ]);
   
   
          $profile_get=Payment::find($request->payment_id);
     $gls_profile_id=$profile_get->link->product->gls_profile_id;
     $gls=profile::find($gls_profile_id);
        
        $seda=$gls->sede;
        $customer_code=$gls->customer_code;
        $contract_code=$gls->contract_code;
        $password=$gls->password;
      
    $shipmentNumber = (string) $request->shipment_number;

    $url = 'https://labelservice.gls-italy.com/ilswebservice.asmx';

    // Alternative XML structure
    $xml = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
                 xmlns:xsd="http://www.w3.org/2001/XMLSchema" 
                 xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
  <soap12:Body>
    <CancelParcel xmlns="https://labelservice.gls-italy.com/">
      <XMLInfo>
        <![CDATA[
        <Info>
          <SedeGls>BC</SedeGls>
          <GlsCustomerCode>23638</GlsCustomerCode>
          <ClientGlsPassword>Scalifypro@123</ClientGlsPassword>
          <ShipmentNumber>{$shipmentNumber}</ShipmentNumber>
        </Info>
        ]]>
      </XMLInfo>
    </CancelParcel>
  </soap12:Body>
</soap12:Envelope>
XML;

    $headers = [
        'Content-Type' => 'application/soap+xml; charset=utf-8',
        'SOAPAction' => 'https://labelservice.gls-italy.com/CancelParcel',
    ];

    try {
        $response = Http::withHeaders($headers)
            ->withBody($xml, 'application/soap+xml')
            ->timeout(60)
            ->post($url);

        \Log::info('GLS Cancel Response: ' . $response->body());

        // Parse the response
        $xmlBody = simplexml_load_string($response->body());
        
        if (isset($xmlBody->children('soap', true)->Body->CancelParcelResponse->CancelParcelResult)) {
            $result = $xmlBody->children('soap', true)->Body->CancelParcelResponse->CancelParcelResult;
           
            if ($result == 'OK') {
                Parcel::where('ShipmentNumber', $shipmentNumber)
                    ->update(['shipment_status' => 'Cancelled']);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Shipment canceled successfully!'
                ]);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Failed to cancel shipment'
        ]);

    } catch (\Exception $e) {
        \Log::error('GLS Cancel Error: ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Error: ' . $e->getMessage()
        ]);
    }
}
public function trackShipment(Request $request)
{
    $request->validate([
        'shipment_number' => 'required|string',
    ]);
    $profile_get=Payment::find($request->payment_id);
    

        $gls_profile_id=$profile_get->link->product->gls_profile_id;
        
        $gls=profile::find($gls_profile_id);
            
            $seda=$gls->sede;
            $customer_code=$gls->customer_code;
            $contract_code=$gls->contract_code;
            $password=$gls->password;
            
    $shipmentNumber = $request->shipment_number;
    $url = $this->service_url;

   
    $xml = <<<XML
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <TrackParcel xmlns="https://labelservice.gls-italy.com/">
      <SedeGls>{$seda}</SedeGls>
      <CodiceClienteGls>{$customer_code}</CodiceClienteGls>
      <PasswordClienteGls>{$password}</PasswordClienteGls>
      <NumeroSpedizione>{$shipmentNumber}</NumeroSpedizione>
    </TrackParcel>
  </soap:Body>
</soap:Envelope>
XML;

    try {
        $response = Http::withHeaders([
            'Content-Type' => 'text/xml; charset=utf-8',
            'SOAPAction' => $this->base_url.'/TrackParcel',
        ])->withBody($xml, 'text/xml')
          ->timeout(60)
          ->post($url);

        $xmlBody = simplexml_load_string($response->body());
        return response()->json(['url'=>$url,'body'=>$xml,'response'=>$xmlBody]);
        $xmlBody->registerXPathNamespace('gls', $this->base_url.'/');

        $parcel = $xmlBody->xpath('//gls:Parcel')[0] ?? null;
        if (!$parcel) {
            return response()->json([
                'status' => 'error',
                'message' => 'Shipment not found.'
            ], 404);
        }

        $data = [
            'shipment_number'       => (string)$parcel->NumeroSpedizione,
            'recipient_name'        => (string)$parcel->DenominazioneDestinatario,
            'recipient_address'     => (string)$parcel->IndirizzoDestinatario,
            'recipient_city'        => (string)$parcel->CittaDestinatario,
            'recipient_province'    => (string)$parcel->ProvinciaDestinatario,
            'shipment_date'         => (string)$parcel->DataSpedizione,
            'weight'                => (string)$parcel->PesoSpedizione,
            'bda'                   => (string)$parcel->Bda,
            'total_packages'        => (string)$parcel->TotaleColli,
            'note'                  => (string)$parcel->NoteSpedizione,
            'label_url'             => (string)$parcel->PdfLabel ?: null,
            'zpl'                   => (string)$parcel->Zpl ?: null,
        ];

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'GLS API request failed: ' . $e->getMessage()
        ], 500);
    }
}
public function getLabel(Request $request)
{
    $request->validate([
        'shipment_number' => 'required|string',
        'type' => 'nullable|string', // pdf or zpl
    ]);
  $profile_get=Payment::find($request->payment_id);
     $gls_profile_id=$profile_get->link->product->gls_profile_id;
     $gls=profile::find($gls_profile_id);
        $seda=$gls->sede;
        $customer_code=$gls->customer_code;
        $contract_code=$gls->contract_code;
   
        $password=$gls->password;
    $shipmentNumber = $request->shipment_number;
    $type = $request->type ?? 'pdf';

    $url = $this->service_url;
    $xmlMethod = $type === 'zpl' ? 'GetZplBySped' : 'GetPdfBySped';

    $xml = <<<XML
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <{$xmlMethod} xmlns="https://labelservice.gls-italy.com/">
      <SedeGls>{$seda}</SedeGls>
      <CodiceClienteGls>{$customer_code}</CodiceClienteGls>
      <PasswordClienteGls>{$password}</PasswordClienteGls>
      <CodiceContratto>{$this->contract_code}</CodiceContratto>
      <ContatoreProgressivo>0</ContatoreProgressivo>
    </{$xmlMethod}>
  </soap:Body>
</soap:Envelope>
XML;

    try {
        $response = Http::withHeaders([
            'Content-Type' => 'text/xml; charset=utf-8',
            'SOAPAction' => $this->base_url."/{$xmlMethod}",
        ])->withBody($xml, 'text/xml')
          ->timeout(60)
          ->post($url);

        $xmlBody = simplexml_load_string($response->body());
        $xmlBody->registerXPathNamespace('gls', $this->base_url.'/');
        $resultNode = $xmlBody->xpath("//gls:{$xmlMethod}Result")[0] ?? null;
        if (!$resultNode || empty($resultNode)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Label not found for this shipment'
            ]);
        }

        $base64 = (string)$resultNode;

        return response()->json([
            'status' => 'success',
            'filename' => $shipmentNumber . ($type === 'zpl' ? '.zpl' : '.pdf'),
            'type' => $type === 'zpl' ? 'text/plain' : 'application/pdf',
            'binary' => $base64 // send base64
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'GLS API request failed: ' . $e->getMessage()
        ]);
    }
}
public function cancelShipment(Request $request)
{
    $request->validate([
        'shipment_number' => 'required|string',
    ]);

    $shipmentNumber = $request->shipment_number;

    try {
        // GLS API call to cancel shipment
        $url = 'https://labelservice.gls-italy.com/ilswebservice.asmx';
        $xml = <<<XML
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <CancelShipment xmlns="https://labelservice.gls-italy.com/">
      <SedeGls>BC</SedeGls>
      <CodiceClienteGls>23638</CodiceClienteGls>
      <PasswordClienteGls>AcNat@247</PasswordClienteGls>
      <CodiceContratto>6818</CodiceContratto>
      <ShipmentNumber>{$shipmentNumber}</ShipmentNumber>
    </CancelShipment>
  </soap:Body>
</soap:Envelope>
XML;

        $response = Http::withHeaders([
            'Content-Type' => 'text/xml; charset=utf-8',
            'SOAPAction' => "https://labelservice.gls-italy.com/CancelShipment",
        ])->withBody($xml, 'text/xml')
          ->timeout(60)
          ->post($url);

        $xmlBody = simplexml_load_string($response->body());
        $xmlBody->registerXPathNamespace('gls', 'https://labelservice.gls-italy.com/');
        $resultNode = $xmlBody->xpath("//gls:CancelShipmentResult")[0] ?? null;

        if(!$resultNode || strtolower((string)$resultNode) !== 'true'){
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to cancel shipment at GLS.'
            ], 400);
        }

        // Update your DB if needed here (e.g. mark as cancelled)

        return response()->json([
            'status' => 'success',
            'message' => "Shipment #{$shipmentNumber} cancelled successfully."
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => "GLS API Error: " . $e->getMessage()
        ], 500);
    }

    
}

    public function ajaxDetails(Request $request)
    {
        $shipmentNumber = $request->get('shipment_number');

        $parcel = Parcel::find($shipmentNumber);

        if (!$parcel) {
            return response()->json(['error' => 'Shipment not found'], 404);
        }

        return response()->json([
            'ShipmentNumber' => $parcel->ShipmentNumber,
            'shipment_status' => $parcel->shipment_status,
            'shipment_date' => $parcel->shipment_date,
            'weight' => $parcel->weight,
            'name' => $parcel->name,
            'phone' => $parcel->phone,
            'city' => $parcel->city,
            'postalcode' => $parcel->postalcode,
            'address' => $parcel->address,
            'sender_name' => $parcel->sender_name,
            'sender_phone' => $parcel->sender_phone,
            'sender_city' => $parcel->sender_city,
            'sender_country' => $parcel->sender_country,
        ]);
    }
        public function process()
    {

      return Payment::query();



    }
  function view_gls(Request $request , $id){
    $decryptedId = (int) unique_decrypt($id);
    $data['status']=PMMOrder::where('payment_id', $decryptedId)->first();
    $data['item'] = $this->process()
        ->where('id', $id)
        ->first();
    $data['link']=$data['item']->link;
    $data['product']=$data['link']->product;
    $data['user']=$data['product']->user;
    $data['user_primary_address']=$data['product']->user->primaryaddress;
    $prduct=$data['product'];

    $data['UpSells']=UppSell::where('product_id',$prduct->id)->get();
   
    $data['notes'] = PmmOrderNote::where('payment_id', $decryptedId)
    ->orderBy('id', 'desc')
    ->get();
    if(!$data['item']){
        abort(404); 
    }
    $data['domain'] = $data['item']->link->customdomain ?? null;
    return view('gls.index', $data);
  }
}