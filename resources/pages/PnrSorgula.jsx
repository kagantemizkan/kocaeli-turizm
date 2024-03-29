import React, { useState, useEffect, useContext } from 'react';
import Header from '../components/Header.jsx';
import OtobusSorgu from '../components/OtobusSorgu.jsx';
import HomeCenter from '../components/HomeCenter.jsx';
import Footer from '../components/Footer.jsx';
import Login from '../components/Login.jsx'
import Dropdown from '../components/Dropdown.jsx';
import { AuthContext } from '../context.jsx';
import toast, { Toaster } from 'react-hot-toast';
import vib from '../assets/vib.png'
import metro from '../assets/metro.png'
import aliosman from '../assets/aliosman.png'
import duzce from '../assets/duzce.png'
import efetur from '../assets/efetur.png'
import kamilkoc from '../assets/kamilkoc.png'
import pamukkale from '../assets/vib.png'
import { AiOutlineExport } from "react-icons/ai";
import { CgArrowsExchangeAlt } from "react-icons/cg";
import { RxCrossCircled } from "react-icons/rx";
import Maps from "../components/Maps"

export default function PnrSorgula() {

  const { pnrKontrol } = useContext(AuthContext);

  const [email, setEmail] = useState("");
  const [pnr, setPnr] = useState("");
  const [loading, setLoading] = useState(false); // Add loading state if needed
  const [pnrValid, setPnrValid] = useState(false)

  const [ticketDetails, setTicketDetails] = useState([])

  const getFirmaImage = (firmaName) => {
    switch (firmaName) {
      case 'VİB':
        return vib;
      case 'Metro':
        return metro;
      case 'Ali Osman':
        return aliosman;
      case 'Düzce':
        return duzce;
      case 'Efetur':
        return efetur;
      case 'Kamil Koç':
        return kamilkoc;
      case 'Pamukkale':
        return pamukkale;
      default:
        return null; // Return null for unknown firms
    }
  };

  const handleSorgula = async () => {
    setLoading(true); // Set loading state to true while waiting for response
    try {
      const bilet = await pnrKontrol(email, pnr);
      if (bilet.success == null || undefined) {
        setPnrValid(true)
        console.log(bilet)
        setTicketDetails(bilet)
      } else {
        toast.error(bilet.message);
      }
    } catch (error) {
      console.error('Error:', error);
    } finally {
      setLoading(false); // Reset loading state after response
    }
  };

  const formatDate = (dateTimeString) => {
    const currentDate = new Date(dateTimeString);
    const dayNames = ['Pazar', 'Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi'];
    const dayName = dayNames[currentDate.getDay()];
    const formattedDate = `${currentDate.getDate()} ${currentDate.toLocaleString('default', { month: 'long' })} ${currentDate.getFullYear()} ${dayName} ${currentDate.getHours()}:${currentDate.getMinutes() < 10 ? '0' : ''}${currentDate.getMinutes()}`;

    return formattedDate;
  };


  return (
    <div>
      <Header />
      {pnrValid ?
        <div className='flex flex-row m-8 border-2 rounded-md mx-[350px]'>
          <div className='flex flex-col w-[550px]'>
            <div className='flex flex-row items-center justify-between px-6 py-3 border-b-2'>
              <img src={getFirmaImage(ticketDetails[0].FirmaAdi)} className='w-36' alt={ticketDetails[0].FirmaAdi + ' Logo'} />
              <p className='font-medium'>Sefer Henüz Başlamadı</p>
            </div>
            <div className='flex flex-col items-center justify-center px-3 py-6 border-dashed border-b-[3px]'>
              <p className='font-semibold text-black text-xl'>{ticketDetails[0].kalkis} Otogarı - {ticketDetails[0].varis} Otogarı</p>
              <p className='font-medium text-black text-lg'>{formatDate(ticketDetails[0].VarisZamani)}</p>
            </div>
            <div className='flex flex-row items-center justify-between gap-5 py-6 px-7'>
              <div>
                <p className='text-lg font-semibold'>
                  PNR:
                </p>
                <p className='text-xl font-semibold text-black'>
                  deneme
                </p>
              </div>
              <div>
                <p className='text-lg font-semibold'>
                  Koltuk Numarası:
                </p>
                <p className='text-xl font-semibold text-black'>
                  {ticketDetails[0].KoltukNumarasi}
                </p>
              </div>
              <div className=''>
                <p className='text-lg font-semibold'>
                  Fiyat
                </p>
                <p className='text-xl font-semibold text-black'>
                  200 TL
                </p>
              </div>
            </div>
            <div className='flex flex-row justify-around pb-4'>
              <button className='flex flex-row items-center justify-center gap-2 font-medium border-2 rounded-md px-3 py-2'>
                <AiOutlineExport className='text-xl' />
                <p>AÇIĞA AL</p>
              </button>
              <button className='flex flex-row items-center justify-center gap-2 font-medium border-2 rounded-md px-3 py-2'>
                <RxCrossCircled className='text-xl' />
                <p>İPTAL ET</p>
              </button>
            </div>
          </div>
          <Maps h={"550px"} startLocation={ticketDetails[0].kalkis + " Otogarı"} endLocation={ticketDetails[0].varis + " Otogarı"} />
        </div>
        :
        <div className='bg-white flex flex-col gap-10 border-2 rounded-xl shadow-sm items-center justify-center mx-[500px] py-6 my-12'>
          <p className='font-medium text-2xl'><span className='text-gray-700 font-semibold'>PNR</span> Numaranız ile Biletinizi Sorgulayın</p>
          <div>
            <input onChange={(e) => setEmail(e.target.value)} value={email} className='border border-gray-300 rounded-md mb-4 py-2 px-4 block w-full' type="text" placeholder="E-Posta" />
            <input onChange={(e) => setPnr(e.target.value)} value={pnr} className='border border-gray-300 rounded-md mb-6 py-2 px-4 block w-full' type="text" placeholder="PNR No" />
            <button onClick={handleSorgula} disabled={!email || !pnr || loading} className='bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-md w-full'>{loading ? 'Sorgulanıyor...' : 'Biletimi Sorgula'}</button>
          </div>
          <p className='text-xs font-semibold'>PNR numaranızı bulmak için onay e-mail veya Cep telefonunuzu kontrol ediniz. </p>
        </div>}
      <Footer />
    </div>
  );
}
