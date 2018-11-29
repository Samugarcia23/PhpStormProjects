package pruebaRetrofitJava;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

import java.util.ArrayList;
import java.util.List;

public class LibroMinMaxListCallback implements Callback<List<Libro>> {

    @Override
    public void onResponse(Call<List<Libro>> call, Response<List<Libro>> response) {
        ArrayList<Libro> arrayList = new ArrayList<>(response.body());
        for (Libro libro : arrayList){
            System.out.println("Codigo: " + libro.getCodigo()+ " || Titulo: " +libro.getTitulo()+" || Paginas: "+libro.getNumpag());
        }

    }

    @Override
    public void onFailure(Call<List<Libro>> call, Throwable throwable) {
        System.out.println("Error, no se ha podido cargar la peticion");
    }
}
