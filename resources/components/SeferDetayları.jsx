import React, { useContext, useState } from 'react';
import { motion, AnimatePresence } from "framer-motion";
import Maps from "../components/Maps"
import { FaWifi } from "react-icons/fa";
import { PiTelevisionSimple } from "react-icons/pi";
import { FaPlug } from "react-icons/fa";

export default function SeferDetayları({ seferDetaylariOpen, setSeferDetaylariOpen }) {
    const handleClickOutside = (e) => {
        if (e.target === e.currentTarget) {
            setSeferDetaylariOpen(!seferDetaylariOpen);
        }
    };

    if (seferDetaylariOpen)
        return (
            <AnimatePresence>
                <motion.div
                    className='fixed inset-0 flex items-center justify-center z-50'
                    initial={{ opacity: 0, backgroundColor: "rgba(0, 0, 0, 0)" }}
                    animate={{ opacity: 1, backgroundColor: "rgba(0, 0, 0, 0.2)" }}
                    exit={{ opacity: 0, backgroundColor: "rgba(0, 0, 0, 0)" }}
                    onClick={handleClickOutside}
                >
                    <div className='relative flex flex-col bg-white rounded-lg shadow-lg transition-all duration-300 w-80 mx-auto'>
                        <p className='border-b-2 py-4 flex justify-center items-center text-[19px] font-semibold'>Sefer Detayları</p>
                        <Maps w="250px" startLocation="izmit Otogarı" endLocation="esenler Otogarı" />
                        <div className='flex flex-col items-center justify-center pt-4'>
                            <p className='text-md font-semibold'>Özellikler:</p>
                            <div className='flex flex-row items-center justify-center pb-4 pt-4 gap-5'>
                                <FaWifi className='text-4xl' />
                                <PiTelevisionSimple className='text-4xl' />
                                <FaPlug className='text-4xl' />
                            </div>
                        </div>
                    </div>
                </motion.div>
            </AnimatePresence>
        );
}