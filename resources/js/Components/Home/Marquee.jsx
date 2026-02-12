import React from "react";
import { motion } from "framer-motion";
import ifs from "../../../images/ifs.png";
import wso2 from "../../../images/wso2.webp";
import rootcode from "../../../images/rootcode.png";
import bluelotus from "../../../images/bluelotus.png";
import creative from "../../../images/creative.png";
import ideahub from "../../../images/ideahub.png";
import adl from "../../../images/adl.jfif";
import allion from "../../../images/allion.jfif";
import pagero from "../../../images/pagero.jpeg";


const MarqueeItem = ({ items, from, to }) => {
  return (
    <div className="flex py-8 overflow-hidden">
      <motion.div
        initial={{ x: `${from}` }}
        animate={{ x: `${to}` }}
        transition={{ duration: 80, repeat: Infinity, ease: "linear" }}
        className="flex flex-shrink-0 gap-16"
      >
        {items.map((item, index) => {
          return (
            <div
              className="flex flex-col items-center justify-center min-w-[140px] px-6"
              key={index}
            >
              <div className="flex items-center justify-center w-24 h-24 p-4 mb-3 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
                <img 
                  src={item.logo} 
                  alt={`${item.name} logo`}
                  className="object-contain max-w-full max-h-full"
                  onError={(e) => {
                    e.target.style.display = 'none';
                    e.target.nextSibling.style.display = 'flex';
                  }}
                />
                <div className="items-center justify-center hidden w-full h-full text-2xl font-bold text-primary-600 dark:text-primary-400">
                  {item.name.charAt(0)}
                </div>
              </div>
              <span className="text-sm font-semibold text-center text-gray-700 dark:text-gray-300">
                {item.name}
              </span>
            </div>
          );
        })}
      </motion.div>

      <motion.div
        initial={{ x: `${from}` }}
        animate={{ x: `${to}` }}
        transition={{ duration: 80, repeat: Infinity, ease: "linear" }}
        className="flex flex-shrink-0 gap-12"
      >
        {items.map((item, index) => {
          return (
            <div
              className="flex flex-col items-center justify-center min-w-[140px] px-6"
              key={`duplicate-${index}`}
            >
              <div className="flex items-center justify-center w-24 h-24 p-4 mb-3 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
                <img 
                  src={item.logo} 
                  alt={`${item.name} logo`}
                  className="object-contain max-w-full max-h-full"
                  onError={(e) => {
                    e.target.style.display = 'none';
                    e.target.nextSibling.style.display = 'flex';
                  }}
                />
                <div className="items-center justify-center hidden w-full h-full text-2xl font-bold text-primary-600 dark:text-primary-400">
                  {item.name.charAt(0)}
                </div>
              </div>
              <span className="text-sm font-semibold text-center text-gray-700 dark:text-gray-300">
                {item.name}
              </span>
            </div>
          );
        })}
      </motion.div>
    </div>
  );
};

const Marquee = () => {
  const upperMarquee = [
    { name: "IFS", logo: ifs },
    { name: "WSO2", logo: wso2 },
    { name: "Rootcode", logo: rootcode },
    { name: "Blue Lotus", logo: bluelotus },
    { name: "Creative Software", logo: creative },
    { name: "Idea Hub", logo: ideahub },
    { name: "ADL", logo: adl },
    { name: "Allion", logo: allion },
    { name: "Pagero", logo: pagero },
  ];



  return (
    <section className="py-20 transition-colors duration-500 bg-gray-50 dark:bg-gray-800">
      <div className="container px-4 mx-auto sm:px-6 lg:px-8">
        <div className="mb-12 text-center">
          <h3 className="mb-4 text-4xl font-bold text-transparent md:text-5xl bg-gradient-to-r from-blue-700 via-purple-600 to-cyan-600 dark:from-blue-300 dark:via-purple-400 dark:to-cyan-400 bg-clip-text drop-shadow-lg">
            Ruhuna DCS Career Fair 2025 Partners
          </h3>
          <p className="max-w-2xl mx-auto text-lg text-gray-700 dark:text-gray-300">
            Trusted by leading companies shaping the future of technology
          </p>
        </div>
        <MarqueeItem items={upperMarquee} from={0} to="-100%" />
      </div>
    </section>
  );
};

export default Marquee;
