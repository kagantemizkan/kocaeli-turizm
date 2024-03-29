import React, { useState, useEffect } from 'react';
import { PiSteeringWheel } from "react-icons/pi";
import PurpleSeat from "../assets/purpleseat.svg";
import BlueSeat from "../assets/blueseat.svg";
import GreenSeat from "../assets/greenseat.svg";
import WhiteSeat from "../assets/whiteseat.svg";
import { IoIosWoman } from "react-icons/io";
import { IoIosMan } from "react-icons/io";

export default function Bus({ selectedSeats, setSelectedSeats, seats }) {

    const [selectedSeat, setSelectedSeat] = useState(null);
    

    const handleClickOutside = (event) => {
        if (selectedSeat && !event.target.closest(".bus-seat")) {
            setSelectedSeat(null);
        }
    };

    useEffect(() => {
        document.addEventListener("mousedown", handleClickOutside);
        return () => {
            document.removeEventListener("mousedown", handleClickOutside);
        };
    }, [selectedSeat]);

    const handleGenderSelect = (gender) => {
        if (selectedSeat) {
            setSelectedSeats([...selectedSeats, { seatNumber: selectedSeat, gender }]);
            setSelectedSeat(null);
        }
    };

    const isSeatSelected = (seatNumber) => {
        return selectedSeats.some(seat => seat.seatNumber === seatNumber);
    };

    const getSeatColor = (seatNumber) => {
        const seat = seats.find(seat => seat.KoltukNumarasi === seatNumber);
    
        if (seat) {
            if (seat.Cinsiyet === 'Erkek') {
                return BlueSeat;
            } else if (seat.Cinsiyet === 'kadın') {
                return PurpleSeat;
            }
        }
    
        // Seçili ise GreenSeat, değilse WhiteSeat dön
        return isSeatSelected(seatNumber) ? GreenSeat : WhiteSeat;
    };
    
    const handleSeatClick = (seatNumber) => {
        const seat = seats.find(seat => seat.KoltukNumarasi === seatNumber);
    
        if (seat && seat.durumu === 'SatinAlinmis') {
            // Koltuğun durumu "SatinAlinmis" ise buton tıklanamaz hale getir
            return;
        }
    
        // Diğer işlemler devam eder
        if (isSeatSelected(seatNumber)) {
            // Koltuk zaten seçili, seçimi kaldır ve diziden çıkar
            const updatedSeats = selectedSeats.filter(seat => seat.seatNumber !== seatNumber);
            setSelectedSeats(updatedSeats);
            setSelectedSeat(null);
        } else {
            setSelectedSeat(seatNumber);
        }
    };
    
    const renderSeatDetails = (seatNumber) => {
        if (selectedSeat === seatNumber) {
            return (
                <div className='absolute z-50 flex bg-white border-2 rounded-full bottom-1 -left-[50px] px-2 py-0.5'>
                    <button onClick={() => handleGenderSelect('male')}>
                        <IoIosMan className='text-[60px] text-[#6D8BA9]' />
                    </button>
                    <button onClick={() => handleGenderSelect('female')}>
                        <IoIosWoman className='text-[60px] text-[#D08A9E]' />
                    </button>
                    <div className="absolute -z-50 w-8 h-8 right-16 top-11 ">
                        <div className="absolute left-0 w-full h-full transform rotate-45 origin-bottom">
                            <div className="bg-white w-full h-full border-b-2 border-r-2"></div>
                        </div>
                    </div>
                </div>
            );
        } else {
            return null;
        }
    };

    return (
        <div className='flex flex-row'>
            <div className='flex items-end border-2 border-r-0 w-[100px] h-[220px] rounded-l-3xl ml-24'>
                <PiSteeringWheel className='text-[60px] -rotate-90 text-gray-400 m-3' />
            </div>
            <div className='flex flex-col justify-between border-2 border-l-0 border-r-0 w-[645px] h-[220px]'>
                <div>
                    <div className='py-4 grid grid-cols-13 gap-x-2.5'>
                        {seats.slice(0, 13).map(seat => (
                            <div key={seat.KoltukNumarasi} className='relative'>
                                <div className="bus-seat">
                                    {renderSeatDetails(seat.KoltukNumarasi)}
                                    {seat.KoltukNumarasi !== 8 && (
                                        <button
                                            className='w-[40px] absolute inset-0'
                                            onClick={() => handleSeatClick(seat.KoltukNumarasi)}>
                                            <img src={getSeatColor(seat.KoltukNumarasi)} alt={'seat'} />
                                        </button>
                                    )}
                                    {seat.KoltukNumarasi !== 8 && (
                                        <div className={`absolute inset-0 top-2 ${seat.KoltukNumarasi > 9 ? "left-2" : "left-3.5"}`}>
                                            {seat.KoltukNumarasi}
                                        </div>
                                    )}
                                </div>
                            </div>
                        ))}
                        <div>a</div>
                    </div>
                    <div className='pt-2 grid grid-cols-13 gap-x-2.5'>
                        {seats.slice(13, 26).map(seat => (
                            <div key={seat.KoltukNumarasi} className='relative'>
                                <div className="bus-seat">
                                    {renderSeatDetails(seat.KoltukNumarasi)}
                                    {seat.KoltukNumarasi !== 21 && (
                                        <button onClick={() => handleSeatClick(seat.KoltukNumarasi)} className='w-[40px] absolute inset-0'>
                                            <img src={getSeatColor(seat.KoltukNumarasi)} alt={'seat'} />
                                        </button>
                                    )}
                                    {seat.KoltukNumarasi !== 21 && (
                                        <div className={`absolute inset-0 top-2 ${seat.KoltukNumarasi > 9 ? "left-2" : "left-3.5"}`}>{seat.KoltukNumarasi}</div>
                                    )}
                                </div>
                            </div>
                        ))}
                        <div>a</div>
                    </div>
                </div>
                <div className='py-4 grid grid-cols-13 gap-x-2.5 gap-y-3'>
                    {seats.slice(26, 39).map(seat => (
                        <div key={seat.KoltukNumarasi} className='relative'>
                            <div className="bus-seat">
                                {renderSeatDetails(seat.KoltukNumarasi)}
                                <button onClick={() => handleSeatClick(seat.KoltukNumarasi)} className='w-[40px] absolute inset-0'>
                                    <img src={getSeatColor(seat.KoltukNumarasi)} alt={'seat'} />
                                </button>
                                <div className={`absolute inset-0 top-2 ${seat.KoltukNumarasi > 9 ? "left-2" : "left-3.5"}`}>{seat.KoltukNumarasi}</div>
                            </div>
                        </div>
                    ))}
                    <div>a</div>
                </div>
            </div>
            <div className='border-2 border-l-0 w-[40px] h-[220px] rounded-r-xl'></div>
        </div>
    )
}