"use client";

import Link from "next/link";
import { usePathname } from "next/navigation";
import { 
  LayoutDashboard, 
  UploadCloud, 
  TableProperties, 
  Download, 
  ShoppingBag 
} from "lucide-react";
import { clsx } from "clsx";

const navItems = [
  { name: "Upload Data", href: "/upload", icon: UploadCloud },
  { name: "Sales Records", href: "/sales", icon: TableProperties },
  { name: "Export & Analytics", href: "/export", icon: Download },
];

export default function Sidebar() {
  const pathname = usePathname();

  return (
    <div className="w-64 bg-[#1e293b] text-white flex flex-col">
      <div className="p-6 flex items-center gap-3">
        <div className="bg-blue-500 p-2 rounded-lg">
          <ShoppingBag className="w-6 h-6" />
        </div>
        <h1 className="text-xl font-bold tracking-tight">ShopEase BD</h1>
      </div>

      <nav className="flex-1 px-4 py-4 space-y-2">
        {navItems.map((item) => {
          const isActive = pathname === item.href;
          return (
            <Link
              key={item.href}
              href={item.href}
              className={clsx(
                "flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group",
                isActive 
                  ? "bg-blue-600 text-white shadow-lg shadow-blue-900/20" 
                  : "text-slate-400 hover:bg-slate-800 hover:text-white"
              )}
            >
              <item.icon className={clsx(
                "w-5 h-5",
                isActive ? "text-white" : "text-slate-400 group-hover:text-white"
              )} />
              <span className="font-medium">{item.name}</span>
            </Link>
          );
        })}
      </nav>

      <div className="p-6 border-t border-slate-800">
        <div className="bg-slate-800/50 p-4 rounded-xl">
          <p className="text-xs text-slate-500 uppercase font-bold tracking-wider mb-2">System Status</p>
          <div className="flex items-center gap-2 text-sm text-green-400 font-medium">
            <div className="w-2 h-2 bg-green-400 rounded-full animate-pulse" />
            API Connected
          </div>
        </div>
      </div>
    </div>
  );
}
